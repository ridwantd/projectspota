<?php

/**
 * Description of db
 *
 * @author Ridwan
 */
class dB {
    var $MySQLHost;
    var $MySQLUser;
    var $MySQLPasswd;
    var $MySQLDb;
    private $dbAccess;
    private $dbResult;
    private $dbRows;
    public $dbError;
    private $debug;
	
	public function __construct($dbsetting)
	{
		$this->MySQLHost = $dbsetting['MySQLHost'];
        $this->MySQLUser = $dbsetting['MySQLUser'];
        $this->MySQLPasswd = $dbsetting['MySQLPasswd'];
        $this->MySQLDb = $dbsetting['MySQLDb'];
		
		$this->db_SetErrorReporting($dbsetting['ERR_report']);
	}
    protected function dbConnect() {
        try {
            $this->dbAccess = new PDO('mysql:host=' . $this->MySQLHost . ';dbname=' . $this->MySQLDb, $this->MySQLUser, $this->MySQLPasswd);
            $this->dbAccess->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $this->dbError("dbConnect", $e->getMessage());
			exit;
        }
    }

    public function dbError($from, $err_msg) {
        if ($pesan_error = $err_msg) {
            if ($this->dbError == TRUE) {
                echo $pesan = "<div style='text-align:center' class='alert alert-error'><strong><strong>System Error!</strong> Function: $from. [$pesan_error]</strong></div>";
            }
        }
    }

    public function dbSelect($table, $field, $arg = "", $debug = FALSE) {
		$this->dbConnect();
        if ($arg != "") {
            //jika mode debug aktif
            if ($debug) {
                echo "SELECT " . $field . " FROM " . $table . " WHERE " . $arg . "<br/>";
                $this->db_SetDebug($debug);
            } else {
                try {
                    $this->dbResult = $this->dbAccess->prepare("SELECT " . $field . " FROM " . $table . " WHERE " . $arg);
                    $this->dbResult->execute();
                } catch (PDOException $e) {
                    $this->dbError("dbSelect", $e->getMessage() . "," . $e->getFile() . "," . $e->getLine());
                    return FALSE;
                }
            }
        } else {
            if ($debug == true) {
                echo "SELECT " . $field . " FROM " . $table . " <br/>";
                $this->db_SetDebug($debug);
            } else {
                try {
                    $this->dbResult = $this->dbAccess->prepare("SELECT " . $field . " FROM " . $table);
                    $this->dbResult->execute();
                } catch (PDOException $e) {
                    $this->dbError("dbSelect", $e->getMessage() . "," . $e->getFile() . "," . $e->getLine());
                    return FALSE;
                }
            }
        }
    }

    public function dbInsert($table, $arg, $debug = FALSE, $log = FALSE) {
		$this->dbConnect();
        $query = "INSERT INTO " . $table . " SET " . $arg;
        if ($debug) {
            echo htmlentities($query) . "<br/>";
        } else {
            try {
                $this->dbResult = $this->dbAccess->prepare($query);
                $this->dbResult->execute();
                if ($log) {
                    //silakan diisi jika ingin menggunakan log
                }
                return true;
            } catch (PDOException $e) {
                $this->dbError("dbInsert", $e->getMessage());
                return FALSE;
            }
        }
    }

    public function dbUpdate($table, $arg, $debug = FALSE, $log = FALSE) {
		$this->dbConnect();
        $query = "UPDATE " . $table . " SET " . $arg;
        if ($debug) {
            echo $query . "<br/>";
        } else {
            try {
                $this->dbResult = $this->dbAccess->prepare($query);
                $this->dbResult->execute();
                if ($log) {
                    //silakan diisi jika ingin menggunakan log
                }
                return true;
            } catch (PDOException $e) {
                $this->dbError("dbUpdate", $e->getMessage());
                return FALSE;
            }
        }
    }

    public function dbDelete($table, $arg, $debug = FALSE, $log = FALSE) {
		$this->dbConnect();
        if ($arg != "") {
            $query = "DELETE FROM " . $table . " WHERE " . $arg;
            if ($debug == true) {
                echo $query . "<br/>";
            } else {
                try {
                    $this->dbResult = $this->dbAccess->prepare($query);
                    $this->dbResult->execute();
                    if ($log) {
                        //silakan diisi jika ingin menggunakan log
                    }
                    return TRUE;
                } catch (PDOException $e) {
                    $this->dbError("dbDelete", $e->getMessage());
                    return FALSE;
                }
            }
        } else {
            $query = "DELETE FROM " . $table;
            if ($debug == true) {
                echo $query . "<br/>";
            } else {
                try {
                    $this->dbResult = $this->dbAccess->prepare($query);
                    $this->dbResult->execute();
                    if ($log) {
                        //silakan diisi jika ingin menggunakan log
                    }
                    return true;
                } catch (PDOException $e) {
                    $this->dbError("dbDelete", $e->getMessage());
                    return FALSE;
                }
            }
        }
    }

   public function runQuery($sql = "", $debug = FALSE) {
		$this->dbConnect();
        if ($sql != "") {
            if ($debug) {
                echo htmlentities($sql) . "<br/>";
            } else {
                try {
                    $this->dbResult = $this->dbAccess->prepare($sql);
                    $this->dbResult->execute();
                    // return TRUE;
                    return $this->dbResult;
                } catch (PDOException $e) {
                    $this->dbError("runQuery", $e->getMessage() . "," . $e->getLine());
                    return FALSE;
                }
            }
        }
    }

    /*
     * dbFetch()
     * dipanggil dengan menggunakan foreach
     */

    public function dbFetch($data=NULL) {
        if (!$this->debug) {
            try {
                if($data!=NULL){
                    return $data->fetch(PDO::FETCH_BOTH);
                }else{
                    return $this->dbResult->fetch(PDO::FETCH_ASSOC);
                }
                
            } catch (PDOException $e) {
                $this->dbError("dbFetch", $e->getMessage() . "," . $e->getFile() . "," . $e->getLine());
                return FALSE;
            }
        }
    }

    public function dbRows($data=NULL) {
        if (!$this->debug) {
            try {
                if($data!=NULL){
                    return $data->rowCount();
                }else{
                    return $this->dbResult->rowCount();
                }
                
            } catch (PDOException $e) {
                $this->dbError("dbRows", $e->getMessage() . "," . $e->getFile() . "," . $e->getLine());
                return FALSE;
            }
        }
    }

    private function db_SetErrorReporting($mode) {
        return $this->dbError = $mode;
    }

    private function db_SetDebug($mode) {
        return $this->debug = $mode;
    }

}

?>
