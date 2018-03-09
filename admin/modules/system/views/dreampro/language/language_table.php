<table id='routertable'>
    <tr>
        <div id='showsort' value='system/language/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 5%;'>
            <a href="javascript:void(0)" class='csort' id="language_id" val="desc" onclick="actsort(this.id)">No</a>
        </th>
        <th style='width: 5%;'>Flag</th>
        <th class='hd-mobile' style='width: 10%;'>
            <a href="javascript:void(0)" class='csort' id="lang_code" val="desc" onclick="actsort(this.id)">ISO Code</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="language_name" val="desc" onclick="actsort(this.id)">Name</a>
        </th>
        <th class='hd-mobile' style='width: 5%;'>
            <a href="javascript:void(0)" class='csort' id="is_active" val="desc" onclick="actsort(this.id)">Active</a>
        </th>
        <th class='hd-mobile' style='width: 5%;'>
            <a href="javascript:void(0)" class='csort' id="is_active" val="desc" onclick="actsort(this.id)">Default</a>
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
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->language_id . "' class='ctab'></td>";
            echo "<td class='center'>" . $i . "</td>";
            echo "<td class='center'><img src=" . $this->config->item('base_static')."/flags/$r->lang_code.png" . "></td>";
            echo "<td class='center upper hd-mobile'>" . $r->lang_code . "</td>";
            echo "<td class='capital'>" . $r->language_name . "</td>";
            echo "<td class='center capital hd-mobile'>" . $r->is_active . "</td>";
            echo "<td class='center capital hd-mobile'>" . $r->is_default . "</td>";
            echo "<td class='center'>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"openform('system/language/edit/". $r->language_id ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('system/language/delete/". $r->language_id ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=8 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
