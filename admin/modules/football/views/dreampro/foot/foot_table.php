<table id='routertable'>
    <tr>
        <div id='showsort' value='football/foot/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 5%;'>
            <?php $id = 'id_foot'; ?>
            <a href="javascript:void(0)" class='csort' id="<?php echo $id; ?>" val="desc" onclick="actsort(this.id)">No</a>
        </th>
        <th>
            <?php $foot = 'foot'; ?>
            <a href="javascript:void(0)" class='csort' id="<?php echo $foot; ?>" val="desc" onclick="actsort(this.id)">Name Foot</a>
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
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->id_foot . "' class='ctab'></td>";
            echo "<td class='center'>" . $i . "</td>";
            echo "<td align='center'>" . $r->foot . "</td>";
            echo "<td class='center'>";

              echo "<a class='btn_action' href='javascript:void(0)' onclick=\"openform('football/foot/edit/". $r->$id ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('football/foot/delete/". $r->$id ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=4 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
