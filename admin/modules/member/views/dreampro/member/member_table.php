<table id='routertable'>
    <tr>
        <div id='showsort' value='news/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="eyenews_id" val="desc" onclick="actsort(this.id)">Profile pic</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="title" val="desc" onclick="actsort(this.id)">username</a>
        </th>
        <th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="news_type" val="desc" onclick="actsort(this.id)">user detail </a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>
    
    <?php
    
    if($count->cc > 0)
    {
        $i= $offset;
        p($dt);
        foreach($dt as $r)
        {
            $pic = $this->library->picUrl($r->pic, $r->url_pic, 'eyeme', 'thumb');

            echo "<tr>";
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->id_member . "' class='ctab'></td>";
            echo "<td class='center'><div class='picproduct'><span style='background-image: url(" . $pic . ");'></span></div></td>";
            echo "<td>" . $r->name . "<br>Username : " . $r->username . "<br></td>";
            echo "<td class='center capital hd-mobile'>" . $r->pic . "</td>";
            echo "<td class='center'>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"openform('member/edit/". $r->id_member ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('member/delete/". $r->id_member ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=5 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
