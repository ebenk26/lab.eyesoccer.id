
<table id='routertable'>
    <tr>
        <div id='showsort' value='event/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 30%;'>
            <a href="javascript:void(0)" class='csort' id="logo" val="desc" onclick="actsort(this.id)">Event</a>
        </th>
        <th style='width: 10%;'>
            <a href="javascript:void(0)" class='csort' id="logo" val="desc" onclick="actsort(this.id)">Logo</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="title" val="desc" onclick="actsort(this.id)">Tim A</a>
        </th>
        <th class='hd-mobile' style='width: 5%;'>
            <a href="javascript:void(0)" class='csort' id="publish_on" val="desc" onclick="actsort(this.id)">Score</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="title" val="desc" onclick="actsort(this.id)">Tim B</a>
        </th>
        <th style='width: 10%;'>
            <a href="javascript:void(0)" class='csort' id="logo" val="desc" onclick="actsort(this.id)">Logo</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>
    
    <?php
    // var_dump($dt);exit();
    if($count->cc > 0)
    {
        $i= $offset;
        foreach($dt as $r)
        {
            $pic_a = $this->library->picUrl($r->url_logo_a, $r->url_logo_a, FDEYEVENT, 'small');
            $pic_b = $this->library->picUrl($r->url_logo_b, $r->url_logo_b, FDEYEVENT, 'small');

            echo "<tr>";
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->id_event . "' class='ctab'></td>";
            echo "<td class='center'><span>" . $r->event . "</span></td>";
            echo "<td class='center'><div class='picproduct'><span style='background-image: url(" . $pic_a . ");'></span></div></td>";
            echo "<td>" . $r->team_a . "</td>";
            echo "<td>" . $r->score_a . " - " . $r->score_b . "</td>";
            echo "<td>" . $r->team_b . "</td>";
            echo "<td class='center'><div class='picproduct'><span style='background-image: url(" . $pic_b . ");'></span></div></td>";
            echo "<td class='center'>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"openform('event/match/edit/". $r->id_jadwal_event ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('event/match/delete/". $r->id_jadwal_event ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=5 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>