<table id='routertable'>
    <tr>
        <div id='showsort' value='member/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>

        <th style='width: 5%;'>
            <a href="javascript:void(0)" class='csort' id="eyenews_id" val="desc" onclick="actsort(this.id)">id</a>
        </th>
       <!--  <th style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="eyenews_id" val="desc" onclick="actsort(this.id)">Profile pic</a>
        </th> -->
        <th style='width: 20%;'>
            <a href="javascript:void(0)" class='csort' id="title" val="desc" onclick="actsort(this.id)">Comment</a>
        </th>
        <th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="news_type" val="desc" onclick="actsort(this.id)">Username </a>
        </th>
        <th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="news_type" val="desc" onclick="actsort(this.id)">Detail</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>
    
    <?php
    if($count->cc > 0)
    {
        $i= $offset;

        foreach($dt as $r)
        {
            $pic = '';

            echo "<tr>";
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->id_comment . "' class='ctab'></td>";
            echo "<td class='center'>". $r->id_comment ."</td>";
            echo "<td class='center'>".$r->comment."</td>";
           # echo "<td><br>".$r->img_caption. "<br></td>";
            echo "<td><br>".$r->username. "<br></td>";
            echo "<td class='center capital hd-mobile'>active : <br> IP address </td>";
            echo "<td class='center'>
                    
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('comment/delete/". $r->id_comment ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=5 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
