<html>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<table>
		<thead>
		<tr>
			<th>รหัสพนักงาน</th>
			<th>ชื่อผู้ใช้</th>
            <th>รหัสผ่าน</th>
			<th>ชื่อ-สกุล</th>
			<th>แผนก</th>
			<th>ตำแหน่ง</th>
			<th>กลุ่ม</th>
		</tr>
		</thead>
	@foreach ($users as $key => $user)
	@if($user->deleted_at == '')
	<tbody>
	<tr>
		<td>{{ $user->code }}</td>
		<td>{{ $user->email }}</td>
        <td>{{ $user->password }}</td>
		<td>{{ $user->prefix }} {{ $user->firstname }} {{ $user->lastname }}</td>
		<td>{{ $user->department }}</td>
		<td>{{ $user->position }}</td>
		<td>
		@if(!empty($user['group_ids']))
			@foreach($user['group_ids'] as $v)
				@foreach($groups as $vgroup)
					@if($v == $vgroup['_id'])
						{{ $vgroup['name'] }}
					@endif
				@endforeach
			@endforeach
		@endif
		</td>
	</tr>
	</tbody>
	@endif
	@endforeach
	</table>
</html>