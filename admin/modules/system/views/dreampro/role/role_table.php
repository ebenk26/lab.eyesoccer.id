<table id='routertable'>
    <tr>
        <div id='showsort' value='system/role/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 5%;'>
            <a href="javascript:void(0)" class='csort' id="role_id" val="desc" onclick="actsort(this.id)">No</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="role_name" val="desc" onclick="actsort(this.id)">Name</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>
    
    <?php
    
    if($count->cc > 0)
    {
        $i= $offset + 1;
        foreach($dt as $r)
        {
            echo "<tr>";
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->role_id . "' class='ctab'></td>";
            echo "<td class='center'>" . $i . "</td>";
            echo "<td class='center'>" . $r->role_name . "</td>";
            echo "<td class='center'>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"openform('system/role/edit/". $r->role_id ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('system/role/delete/". $r->role_id ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=4 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
