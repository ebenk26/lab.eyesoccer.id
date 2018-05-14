<table id='routertable'>
    <tr>
        <?php $sv = $this->library->sub_view(); ?>
        <div id='showsort' value='football/clubcareer/search<?php echo $sv->idstay; ?>'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="id_career" val="desc" onclick="actsort(this.id)">Career Detail</a>
        </th>
        <th style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="coach" val="desc" onclick="actsort(this.id)">Coach</a>
        </th>
		<th style='width: 10%;'>
            <a href="javascript:void(0)" class='csort' id="rank" val="desc" onclick="actsort(this.id)">Rank</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>
    
    <?php
    
    if($count->cc > 0)
    {
        $i= $offset;
        foreach($dt as $r)
        {
            echo "<tr>";
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->id_career . "' class='ctab'></td>";
            echo "<td class='capital'>" . $r->tournament . "<br>" . $r->month . " " . $r->year . "</td>";
            echo "<td class='center capital'>" . $r->coach . "</td>";
            echo "<td class='center capital'>" . $r->rank . "</td>";
            echo "<td class='center'>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"openform('football/clubcareer/edit/". $r->id_career . $sv->idstay ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('football/clubcareer/delete/". $r->id_career  . $sv->idstay ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=5 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
