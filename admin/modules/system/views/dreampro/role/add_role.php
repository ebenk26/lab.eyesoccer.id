<div class='boxtitle'><?php echo $title; ?></div>
<div id='boxmessage'></div>

<div id='boxjq'>
    <div id='boxbutton'>
        <a href="javascript:void(0)" id='button' onclick="actmenu('system/role/view')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open('system/role/save', array('name' => 'form_add', 'id' => 'form_add'));?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='val' value='true'>
                        <div class='pad-b20'>
                            <label>Role Name</label>
                            <input type='text' name='role_name' id='role_name' class='cinput input_multi' required>
                        </div>
                    </div>
                </div>
                
                <div class='boxtab pad-all mg-b20'>
                    <h1>Role Access</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b20'>
                            <table id='routertable'>
                                <tr>
                                    <th>Menu Name</th><th>Access</th><th>Created</th><th>Updated</th><th>Deleted</th>
                                </tr>
                                <?php
                                    $i = 0;
                                    foreach($dt as $r)
                                    {
                                        echo "<tr>";
                                        echo "<td>$r->menu_name <input type='hidden' name='menu_id[]' value='$r->menu_id'></td>";
                                        echo "<td class='center'><input type='checkbox' name='menu_access[$i]' value='1' title='Access'></td>";
                                        echo "<td class='center'><input type='checkbox' name='menu_created[$i]' value='1' title='Created'></td>";
                                        echo "<td class='center'><input type='checkbox' name='menu_updated[$i]' value='1' title='Updated'></td>";
                                        echo "<td class='center'><input type='checkbox' name='menu_deleted[$i]' value='1' title='Deleted'></td>";
                                        echo "</tr>";
                                        
                                        $i++;
                                        
                                        $s1 = $this->catalog->get_menu(array('menu_parent' => $r->menu_id, 'sortBy' => 'menu_order', 'sortDir' => 'asc'));
                                        if($s1)
                                        {
                                            foreach($s1 as $r1)
                                            {
                                                echo "<tr>";
                                                echo "<td>----| $r1->menu_name <input type='hidden' name='menu_id[]' value='$r1->menu_id'></td>";
                                                echo "<td class='center'><input type='checkbox' name='menu_access[$i]' value='1' title='Access'></td>";
                                                echo "<td class='center'><input type='checkbox' name='menu_created[$i]' value='1' title='Created'></td>";
                                                echo "<td class='center'><input type='checkbox' name='menu_updated[$i]' value='1' title='Updated'></td>";
                                                echo "<td class='center'><input type='checkbox' name='menu_deleted[$i]' value='1' title='Deleted'></td>";
                                                echo "</tr>";
                                                
                                                $i++;
                                                
                                                $s2 = $this->catalog->get_menu(array('menu_parent' => $r1->menu_id, 'sortBy' => 'menu_order', 'sortDir' => 'asc'));
                                                if($s2)
                                                {
                                                    foreach($s2 as $r2)
                                                    {
                                                        echo "<tr>";
                                                        echo "<td>--------| $r2->menu_name <input type='hidden' name='menu_id[]' value='$r2->menu_id'></td>";
                                                        echo "<td class='center'><input type='checkbox' name='menu_access[$i]' value='1' title='Access'></td>";
                                                        echo "<td class='center'><input type='checkbox' name='menu_created[$i]' value='1' title='Created'></td>";
                                                        echo "<td class='center'><input type='checkbox' name='menu_updated[$i]' value='1' title='Updated'></td>";
                                                        echo "<td class='center'><input type='checkbox' name='menu_deleted[$i]' value='1' title='Deleted'></td>";
                                                        echo "</tr>";
                                                        
                                                        $i++;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Action</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b18'>
                            <div class='layout-row'>
                                <span class='flex'></span>
                                <input type='submit' value='Save' id='btn_submit' onclick="saveadd('system/role/save')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>