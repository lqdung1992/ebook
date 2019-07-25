
<fieldset style="width: 500px; margin: auto;"  height="400px" >
	<table>
		<tr>
			<td colspan="2"><h4>Bạn thân mến! Bạn đã sử dụng mail này để xác thực tài khoản tại NN - Ebook.</h4></td>
			
		</tr>
		<tr>
			<td colspan="2">Dưới đây là thông tin mà bạn đã xác thực: </td>
		
		</tr>
		<tr>
			<td>Tên:</td>
			<td>{{$user->name}}</td>
		</tr>
		<tr>
			<td>Mail:</td>
			<td></td>
		</tr>
		<tr>
			<td>Số điện thoại:</td>
			<td></td>
		</tr>
		<tr>
			<td>Mật khẩu mới:</td>
			<td>{{$user->password}}</td>
		</tr>
		<tr>
			<td colspan="2">Bạn phải đổi lại mật khẩu bằng mật khẩu mà chúng tối đã gửi vì lợi ích của chính bạn. </td>
		</tr>
	</table>
</fieldset>