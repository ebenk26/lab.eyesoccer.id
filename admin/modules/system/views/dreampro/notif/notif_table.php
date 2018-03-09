<table id='routertable'>
    <tr>
        <div id='showsort' value='system/notif/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 5%;'>
            <a href="javascript:void(0)" class='csort' id="notif_id" val="desc" onclick="actsort(this.id)">No</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="notif_name" val="desc" onclick="actsort(this.id)">Subject</a>
        </th>
        <th class='hd-mobile' style='width: 25%;'>
            <a href="javascript:void(0)" class='csort' id="notif_type" val="desc" onclick="actsort(this.id)">Type</a>
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
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->notif_id . "' class='ctab'></td>";
            echo "<td class='center'>" . $i . "</td>";
            echo "<td>" . $r->notif_name . "</td>";
            echo "<td class='center capital hd-mobile'>" . $this->library->clear_sym($r->notif_type) . "</td>";
            echo "<td class='center'>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"openform('system/notif/edit/". $r->notif_id ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('system/notif/delete/". $r->notif_id ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=5 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
