<table id='routertable'>
    <tr>
        <div id='showsort' value='system/user/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 5%;'>
            <a href="javascript:void(0)" class='csort' id="user_id" val="desc" onclick="actsort(this.id)">No</a>
        </th>
        <th class='hd-mobile' style='width: 20%;'>
            <a href="javascript:void(0)" class='csort' id="user_name" val="desc" onclick="actsort(this.id)">Username</a>
        </th>
        <th class='hd-mobile' style='width: 25%;'>
            <a href="javascript:void(0)" class='csort' id="user_fname" val="desc" onclick="actsort(this.id)">Fullname</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="user_email" val="desc" onclick="actsort(this.id)">Email</a>
        </th>
        <th class='hd-mobile' style='width: 10%;'>
            <a href="javascript:void(0)" class='csort' id="user_level" val="desc" onclick="actsort(this.id)">Level</a>
        </th>
        <th class='hd-mobile' style='width: 5%;'>
            <a href="javascript:void(0)" class='csort' id="is_active" val="desc" onclick="actsort(this.id)">Active</a>
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
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->user_id . "' class='ctab'></td>";
            echo "<td class='center'>" . $i . "</td>";
            echo "<td class='center hd-mobile'>" . $r->user_name . "</td>";
            echo "<td class='center hd-mobile'>" . $r->user_fname . "</td>";
            echo "<td class='center'>" . $r->user_email . "</td>";
            echo "<td class='center capital hd-mobile'>" . $r->user_level . "</td>";
            echo "<td class='center capital hd-mobile'>" . $this->enum->active_string($r->is_active) . "</td>";
            
            if($this->session->userdata('user_level') == 'admin')
            {
                echo "<td class='center'>
                        <a class='btn_action' href='javascript:void(0)' onclick=\"openform('system/user/edit/". $r->user_id ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                        <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('system/user/delete/". $r->user_id ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                     </td>";
            } else {
                echo "<td class='center'>
                        <a class='btn_action' href='javascript:void(0)' onclick=\"openform('system/user/edit/". $r->user_id ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                     </td>";
            }
            
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=8 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
