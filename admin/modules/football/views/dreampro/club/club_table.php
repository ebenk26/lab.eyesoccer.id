<table id='routertable'>
    <tr>
        <div id='showsort' value='football/club/search'></div>
        <th style='width: 5%;'>
            <input type='checkbox' name='checkall' id='checkall' onclick='actcheckall(this.id);'>
        </th>
		<th style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="id_club" val="desc" onclick="actsort(this.id)">Image</a>
        </th>
        <th>
            <a href="javascript:void(0)" class='csort' id="name" val="desc" onclick="actsort(this.id)">Club Detail</a>
        </th>
		<th class='hd-mobile' style='width: 15%;'>
            <a href="javascript:void(0)" class='csort' id="id_competition" val="desc" onclick="actsort(this.id)">Competition</a>
        </th>
		<th class='hd-mobile' style='width: 10%;'>
            <a href="javascript:void(0)" class='csort' id="is_active" val="desc" onclick="actsort(this.id)">Active</a>
        </th>
        <th style='width: 10%;'>Action</th>
    </tr>
    
    <?php
    
    if($count->cc > 0)
    {
        $i= $offset;
        foreach($dt as $r)
        {
            $pic = $this->library->picUrl($r->logo, $r->url_logo, FDCLUB, 'small');

            echo "<tr>";
            echo "<td class='center'><input type='checkbox' name='selected[]' value='" . $r->id_club . "' class='ctab'></td>";
            echo "<td class='center'><div class='picproduct'><span style='background-image: url(" . $pic . ");'></span></div></td>";
            echo "<td>" . $r->name ."<br>Phone : $r->phone<br>Establish Date : " . date('d M Y', strtotime($r->establish_date)) . "</td>";
            echo "<td class='center capital hd-mobile'>" . $r->competition . "</td>";
            echo "<td class='center capital hd-mobile'>" . $this->enum->active_string($r->is_active) . "</td>";
            echo "<td class='center'>
					<a class='btn_action mg-r5' href='javascript:void(0)' onclick=\"actmenu('football/clubcareer/view/?id=". $r->id_club ."')\" title='View'><i class='fa fa-search fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"openform('football/club/edit/". $r->id_club ."')\" title='Edit'><i class='fa fa-edit fa-fw'></i></a>
                    <a class='btn_action' href='javascript:void(0)' onclick=\"deleteid('football/club/delete/". $r->id_club ."')\" title='Remove'><i class='fa fa-minus-square fa-fw'></i></a>
                 </td>";
            echo "</tr>";
            
            $i++;
        }
    } else {
        echo "<tr><td colspan=8 style='text-transform: none;'>Data is not available</td></tr>";
    }
    
    ?>
</table>
