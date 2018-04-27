<table id='routertable'>
    <tr>
        <div id='showsort' value='football/clubcareer/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
        <th style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="id_career" val="desc" onclick="actsort(this.id)">ID</a>
        </th>
		<th style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="month" val="desc" onclick="actsort(this.id)">Bulan</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="year" val="desc" onclick="actsort(this.id)">Tahun</a>
        </th>
        <th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="tournament" val="desc" onclick="actsort(this.id)">Turnamen/Kompetisi</a>
        </th>
		<th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="rank" val="desc" onclick="actsort(this.id)">Peringkat Juara</a>
        </th>
		<th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="coach" val="desc" onclick="actsort(this.id)">Pelatih</a>
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
			echo "<td>" . $r->id_career ."</td>";
            echo "<td class='center capital hd-mobile'>" . $r->month . "</td>";
            echo "<td class='center capital hd-mobile'>" . $r->year . "</td>";
            echo "<td class='center capital hd-mobile'>" . $r->tournament . "</td>";
            echo "<td class='center capital hd-mobile'>" . $r->rank . "</td>";
            echo "<td class='center capital hd-mobile'>" . $r->coach . "</td>";
            echo "<td class='center'>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"openform('football/clubcareer/edit/". $r->id_career ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('football/clubcareer/delete/". $r->id_career ."?id=". $r->id_club ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=5 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
