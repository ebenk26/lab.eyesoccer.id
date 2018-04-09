<table id='routertable'>
    <tr>
        <div id='showsort' value='event/category/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 5%;'>
            <?php $id = (isset($_GET['id'])) ? 'id_league' : 'id_competition'; ?>
            <a href="javascript:void(0)" class='csort' id="<?php echo $id; ?>" val="desc" onclick="actsort(this.id)">No</a>
        </th>
        <th style="text-align: left;">
            <?php $name = (isset($_GET['id'])) ? 'league' : 'competition'; ?>
            <a href="javascript:void(0)" class='csort' id="<?php echo $name; ?>" val="desc" onclick="actsort(this.id)">Name</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>
    
    <?php
    
    if($count->cc > 0)
    {
        $sv = $this->library->sub_view();

        $i= $offset;
        foreach($dt as $r)
        {
            echo "<tr>";
            echo "  <td class='center'> 
                        <input type='checkbox' name='selected[]' value='" . $r->$id . "' class='ctab'> 
                    </td>";
            echo "  <td class='center'>" . $i . "</td>";
            echo "  <td>" . $r->$name . "</td>";
            echo "  <td class='center'>";
                        if(empty($_GET['id']))
                        {
                            echo "<a class='btn_action mg-r5' href='javascript:void(0)' onclick=\"actmenu('football/competition/view/?id=". $r->$id.$sv->idsub ."')\" title='League'><i class='fa fa-search fa-fw'></i></a>";
                        }
            echo "      <a class='btn_action' href='javascript:void(0)' onclick=\"openform('football/competition/edit/". $r->$id ."$sv->idstay')\" title='Edit'> 
                            <i class='fa fa-edit fa-fw'></i> 
                        </a>
                        <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('football/competition/delete/". $r->$id ."$sv->idstay')\" title='Remove'> 
                            <i class='fa fa-minus-square fa-fw'></i> 
                        </a>
                    </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=4 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
