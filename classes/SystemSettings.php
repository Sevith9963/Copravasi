<?php
// Ensure config is loaded and session is started early
if (!class_exists('DBConnection')) {
    require_once('../config.php'); // config.php should already handle session_start()
}

class SystemSettings extends DBConnection {
    public function __construct() {
        parent::__construct();
    }

    function check_connection() {
        return $this->conn;
    }

    function load_system_info() {
        $sql = "SELECT * FROM system_info";
        $qry = $this->conn->query($sql);
        while ($row = $qry->fetch_assoc()) {
            $_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
        }
    }

    function update_system_info() {
        $sql = "SELECT * FROM system_info";
        $qry = $this->conn->query($sql);
        while ($row = $qry->fetch_assoc()) {
            if (isset($_SESSION['system_info'][$row['meta_field']])) {
                unset($_SESSION['system_info'][$row['meta_field']]);
            }
            $_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
        }
        return true;
    }

    function update_settings_info() {
        foreach ($_POST as $key => $value) {
            if (!in_array($key, ["about_us", "privacy_policy"])) {
                $value = str_replace("'", "&apos;", $value);
                if (isset($_SESSION['system_info'][$key])) {
                    $this->conn->query("UPDATE system_info SET meta_value = '{$value}' WHERE meta_field = '{$key}' ");
                } else {
                    $this->conn->query("INSERT INTO system_info SET meta_value = '{$value}', meta_field = '{$key}' ");
                }
            }
        }

        // Save HTML files
        if (isset($_POST['about_us'])) {
            file_put_contents('../about.html', $_POST['about_us']);
        }
        if (isset($_POST['privacy_policy'])) {
            file_put_contents('../privacy_policy.html', $_POST['privacy_policy']);
        }

        // Handle file uploads
        foreach (['img' => 'logo', 'cover' => 'cover'] as $input => $meta) {
            if (isset($_FILES[$input]) && $_FILES[$input]['tmp_name'] != '') {
                $fname = 'uploads/' . strtotime(date('y-m-d H:i')) . '_' . $_FILES[$input]['name'];
                move_uploaded_file($_FILES[$input]['tmp_name'], '../' . $fname);

                if (isset($_SESSION['system_info'][$meta])) {
                    $this->conn->query("UPDATE system_info SET meta_value = '{$fname}' WHERE meta_field = '{$meta}' ");
                    if (is_file('../' . $_SESSION['system_info'][$meta])) {
                        unlink('../' . $_SESSION['system_info'][$meta]);
                    }
                } else {
                    $this->conn->query("INSERT INTO system_info SET meta_value = '{$fname}', meta_field = '{$meta}' ");
                }
            }
        }

        $update = $this->update_system_info();
        $flash = $this->set_flashdata('success', 'System Info Successfully Updated.');

        if ($update && $flash) {
            return true;
        }
    }

    // Session utility functions
    function set_userdata($field = '', $value = '') {
        if (!empty($field) && !empty($value)) {
            $_SESSION['userdata'][$field] = $value;
        }
    }

    function userdata($field = '') {
        return !empty($field) && isset($_SESSION['userdata'][$field])
            ? $_SESSION['userdata'][$field]
            : null;
    }

    function set_flashdata($flash = '', $value = '') {
        if (!empty($flash) && !empty($value)) {
            $_SESSION['flashdata'][$flash] = $value;
            return true;
        }
    }

    function chk_flashdata($flash = '') {
        return isset($_SESSION['flashdata'][$flash]);
    }

    function flashdata($flash = '') {
        if (!empty($flash)) {
            $_tmp = $_SESSION['flashdata'][$flash] ?? null;
            unset($_SESSION['flashdata']);
            return $_tmp;
        }
        return false;
    }

    function sess_des() {
        if (isset($_SESSION['userdata'])) {
            unset($_SESSION['userdata']);
        }
        return true;
    }

    function info($field = '') {
        return !empty($field) && isset($_SESSION['system_info'][$field])
            ? $_SESSION['system_info'][$field]
            : false;
    }

    function set_info($field = '', $value = '') {
        if (!empty($field) && !empty($value)) {
            $_SESSION['system_info'][$field] = $value;
        }
    }
}

// Initialize and load system settings
$_settings = new SystemSettings();
$_settings->load_system_info();

// Handle AJAX function if present
$action = isset($_GET['f']) ? strtolower($_GET['f']) : 'none';
$sysset = new SystemSettings();

switch ($action) {
    case 'update_settings':
        // 🛑 Prevent output before headers if session not started
        header('Content-Type: application/json');
        echo json_encode($sysset->update_settings_info());
        break;
    default:
        // No direct output
        break;
}
?>
