<table id='routertable'>
    <tr>
        <div id='showsort' value='store/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 5%;'>
            <a href="javascript:void(0)" class='csort' id="id" val="desc" onclick="actsort(this.id)">No</a>
        </th>
        <th style='width: 10%;'>
            <a href="javascript:void(0)" class='csort' id="pic" val="desc" onclick="actsort(this.id)">Logo</a>
        </th>
        <th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="name" val="desc" onclick="actsort(this.id)">Name</a>
        </th>
        <th class='hd-mobile' style='width: 10%;'>
            <a href="javascript:void(0)" class='csort' id="created_date" val="desc" onclick="actsort(this.id)">Created Date</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>
    
    <?php
    if($count->cc > 0)
    {
        $i= $offset;
        foreach($dt as $r)
        {
            $pic = $this->library->picUrl($r->pic, $r->url_pic, 'eyemarket', 'thumb');

            echo "<tr>";
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->id . "' class='ctab'></td>";
            echo "<td class='center'>" . $r->id . "</td>";
            echo "<td class='center'><div class='picproduct'><span style='background-image: url(" . $pic . ");'></span></div></td>";
            echo "<td class='center'>" . $r->name;
            echo "<td class='center'>" . $r->created_date;
            echo "<td class='center'>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"openform('store/edit/". $r->id ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('store/delete/". $r->id ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=5 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
