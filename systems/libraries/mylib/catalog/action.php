<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Action
{

    var $query_string = '';
    var $command = '';
    var $vlink = '';

    function __construct()
    {
        $this->ci = &get_instance();
        $this->vlink = $this->ci->config->item('aes_vlink');
    }

    function __vlink($table = '')
    {
        $vlink = '';
        switch ($table) {
            case 'we_users':
                $vlink = $this->vlink . '.';
                break;
        }

        return $vlink . $table;
    }

    function insert($options = array())
    {
        $this->query_string = 'INSERT INTO ' . $this->__vlink($options['table']) . ' (';

        $i = 0;
        foreach ($options['insert'] as $name => $val) {
            if ($i > 0) {
                $this->query_string .= ', ' . $name;
            } else {
                $this->query_string .= $name;
            }

            $i++;
        }

        $this->query_string .= ') VALUES (';

        $i = 0;
        foreach ($options['insert'] as $name => $val) {
            if ($i > 0) {
                $this->query_string .= ", '" . $this->ci->library->textflush($val) . "'";
            } else {
                $this->query_string .= "'" . $this->ci->library->textflush($val) . "'";
            }

            $i++;
        }

        $this->query_string .= ')';

        try {
            $this->ci->db->query($this->query_string);
        } catch (Exception $e) {
            return $this->ci->validation->return_message(Validation::insert, FALSE, array('xcss' => 'boxfailed'));
        }
        return $this->ci->validation->return_message(Validation::insert, TRUE, array('xcss' => 'boxsuccess', 'affected' => $this->ci->db->affected_rows()));
    }

    function update($options = array())
    {
        $this->query_string = 'UPDATE ' . $this->__vlink($options['table']) . ' SET ';

        $i = 0;
        foreach ($options['update'] as $name => $val) {
            if ($i > 0) {
                if (isset($options['clearset'])) {
                    $this->query_string .= ", " . $name . "=" . $val;
                } else {
                    if (isset($options['aescrypt'])) {
                        $this->query_string .= ", " . $name . "=AES_ENCRYPT('" . $val . "', UNHEX(SHA2('" . $this->ci->config->item('aes_encrypt') . "', 256)))";
                    } else {
                        $this->query_string .= ", " . $name . "='" . $this->ci->library->textflush($val) . "'";
                    }
                }
            } else {
                if (isset($options['clearset'])) {
                    $this->query_string .= $name . "=" . $val;
                } else {
                    if (isset($options['aescrypt'])) {
                        $this->query_string .= $name . "=AES_ENCRYPT('" . $val . "', UNHEX(SHA2('" . $this->ci->config->item('aes_encrypt') . "', 256)))";
                    } else {
                        $this->query_string .= $name . "='" . $this->ci->library->textflush($val) . "'";
                    }
                }
            }

            $i++;
        }

        if (isset($options['where'])) {
            $i = 0;
            foreach ($options['where'] as $name => $val) {
                if ($i > 0) {
                    $this->query_string .= " AND " . $name . "='" . $val . "'";
                } else {
                    $this->query_string .= " WHERE " . $name . "='" . $val . "'";
                }

                $i++;
            }
        }

        if (isset($options['where_not'])) {
            $i = 0;
            foreach ($options['where_not'] as $name => $val) {
                if ($i > 0) {
                    $this->query_string .= " AND " . $name . "!='" . $val . "'";
                } else {
                    if ($x > 0) {
                        $this->query_string .= " AND " . $name . "!='" . $val . "'";
                    } else {
                        $this->query_string .= " WHERE " . $name . "!='" . $val . "'";
                    }
                }

                $i++;
            }
        }

        if (isset($options['where_in'])) {
            $i = 0;
            foreach ($options['where_in'] as $name => $val) {
                if ($i > 0) {
                    $this->query_string .= " AND " . $name . " IN (" . $val . ")";
                } else {
                    if ($x > 0) {
                        $this->query_string .= " AND " . $name . " IN (" . $val . ")";
                    } else {
                        $this->query_string .= " WHERE " . $name . " IN (" . $val . ")";
                    }
                }

                $i++;
            }
        }

        if (isset($options['where_not_in'])) {
            $i = 0;
            foreach ($options['where_not_in'] as $name => $val) {
                if ($i > 0) {
                    $this->query_string .= " AND " . $name . " NOT IN (" . $val . ")";
                } else {
                    if ($x > 0) {
                        $this->query_string .= " AND " . $name . " NOT IN (" . $val . ")";
                    } else {
                        $this->query_string .= " WHERE " . $name . " NOT IN (" . $val . ")";
                    }
                }

                $i++;
            }
        }

        try {
            $this->ci->db->query($this->query_string);
        } catch (Exception $e) {
            return $this->ci->validation->return_message(Validation::update, FALSE, array('xcss' => 'boxfailed'));
        }
        return $this->ci->validation->return_message(Validation::update, TRUE, array('xcss' => 'boxsuccess', 'affected' => $this->ci->db->affected_rows()));
    }

    function delete($options = array())
    {
        $this->query_string = 'DELETE FROM ' . $this->__vlink($options['table']) . ' ';

        if (isset($options['where'])) {
            $i = 0;
            $x = 0;
            foreach ($options['where'] as $name => $val) {
                if ($i > 0) {
                    $this->query_string .= " AND " . $name . "='" . $val . "'";
                } else {
                    $this->query_string .= " WHERE " . $name . "='" . $val . "'";
                    $x = 1;
                }

                $i++;
            }
        }

        if (isset($options['where_not'])) {
            $i = 0;
            foreach ($options['where_not'] as $name => $val) {
                if ($i > 0) {
                    $this->query_string .= " AND " . $name . "!='" . $val . "'";
                } else {
                    if ($x > 0) {
                        $this->query_string .= " AND " . $name . "!='" . $val . "'";
                    } else {
                        $this->query_string .= " WHERE " . $name . "!='" . $val . "'";
                    }
                }

                $i++;
            }
        }

        if (isset($options['where_in'])) {
            $i = 0;
            foreach ($options['where_in'] as $name => $val) {
                if ($i > 0) {
                    $this->query_string .= " AND " . $name . " IN (" . $val . ")";
                } else {
                    if ($x > 0) {
                        $this->query_string .= " AND " . $name . " IN (" . $val . ")";
                    } else {
                        $this->query_string .= " WHERE " . $name . " IN (" . $val . ")";
                    }
                }

                $i++;
            }
        }

        if (isset($options['where_not_in'])) {
            $i = 0;
            foreach ($options['where_not_in'] as $name => $val) {
                if ($i > 0) {
                    $this->query_string .= " AND " . $name . " NOT IN (" . $val . ")";
                } else {
                    if ($x > 0) {
                        $this->query_string .= " AND " . $name . " NOT IN (" . $val . ")";
                    } else {
                        $this->query_string .= " WHERE " . $name . " NOT IN (" . $val . ")";
                    }
                }

                $i++;
            }
        }

        try {
            $this->ci->db->query($this->query_string);
        } catch (Exception $e) {
            return $this->ci->validation->return_message(Validation::delete, FALSE, array('xcss' => 'boxfailed'));
        }
        return $this->ci->validation->return_message(Validation::delete, TRUE, array('xcss' => 'boxsuccess', 'affected' => $this->ci->db->affected_rows()));
    }
}
