<!-- BEGIN: main -->

<!-- BEGIN: error -->
<div class="alert alert-danger"> {ERROR} </div>
<!-- END: error -->

<!-- BEGIN: success -->
<div class="alert alert-success">{success}</div>
<!-- END: success -->

<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
<div class="form-group row">
	<div class="col-md-2">
		<label for=""><strong>Tên</strong> </label>
	</div>
	<div class="col-md-8">
		<input class="fore-control" type="text" name="fname" value="{DATA.fname}" placeholder="nhập tên">
	</div>
</div>
<div class="form-group row">
	<div class="col-md-2">
		<label for=""><strong>Tuổi</strong> </label>
	</div>
	<div class="col-md-8">
		<input class="fore-control" type="number" min="0" max="100" name="age" value="{DATA.age}" placeholder="nhập tuổi">
	</div>
</div>
<div class="form-group row">
	<div class="col-md-2">
		<label for=""><strong>Địa chỉ</strong> </label>
	</div>
	<div class="col-md-8">
		<input class="fore-control" type="text" name="address" value="{DATA.address}" placeholder="nhập địa chỉ">
	</div>
</div>
<div class="form-group row">
	<div class="col-md-2">
		<label for=""><strong>Email</strong> </label>
	</div>
	<div class="col-md-8">
		<input class="fore-control" type="text" name="email" value="{DATA.email}" placeholder="nhập email">
	</div>
</div>
<div class="form-group row">
	<div class="col-md-2">
		<label for=""><strong>giới tính</strong> </label>
	</div>
	<div class="col-md-8">
		<!-- BEGIN: gender -->
		<input {gender.checked} class="form-control" type="radio" name="gender" value="{gender.key}">{gender.title}
		<!-- END: gender -->
	</div>
</div>

<div class="form-group row">
    <div class="col-md-2">
        <label for=""><strong>Địa chỉ</strong></label>
    </div>
    <div class="col-md-8">
            <select class="col-md-6" name="province" id="province" onchange="change_province()">
            <option value="0">------</option>
            <!-- BEGIN: province -->
            <option value="{province.key}">{province.title}</option>
            <!-- END: province -->
	        </select>
            <select class="col-md-6" name="district" id="district" onchange="change_district()">
                <option value="0">------</option>
            </select>
            <select class="col-md-6" name="ward" id="ward">
            	<option value="0">------</option>
            </select>
          
    </div>
</div>
<div class="form-group row">
	<div class="col-md-2">
		<label for=""><strong>Số nhà</strong></label>
	</div>
	<div class="col-md-8">
		<input class="form-control" type="text" name="address" value="{DATA.address}" placeholder="Nhập địa chỉ">
	</div>
</div>



    <div class="text-center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>
<div class="table-reponsive">
	<table class="table table-striped table-bordered table-hover">
		<thread>
			<tr>
				<th>STT</th>
				<th>Tên</th>
				<th>Tuổi</th>
				<th>Địa chỉ</th>
				<th>Email</th>
				<th>Giới tính</th>
				<th>Chức năng</th>
			</tr>
		</thread>
		<tbody>
		<!-- BEGIN: loop -->
		<tr>
			<td>{DATA.stt}</td>
			<td>{DATA.fname}</td>
			<td>{DATA.age}</td>
			<td>{DATA.address}</td>
			<td>{DATA.email}</td>
			<td>{DATA.gender}</td>
			<td>
				<a href="{DATA.link_edit}">Sửa</a> - <a href="">Xoá</a>
			</td>
		</tr>
		<!-- END: loop -->
		</tbody>	
	</table>	
</div>


<script >

	$(document).ready(function(){
		change_province();
	});


function change_province() {

        var province_id = $('#province').val();
        
        data = {
            'action' : 'change_province',
            'province_id' : province_id
        }
        $.ajax({
            type: "POST",
            url: "",
            cache: !1,
            data: data,
            success: function (res) {
                if (res != '') {
                    $('#district').html(res);
                } else {
                    $('#district').html('<option value="0">------</option>');
                }
            }
        })
    }

function change_district() {

    	var district_id = $('#district').val();
    	data = {
    		'action1' : 'change_district',
    		'district_id' : district_id
    	}
    	$.ajax({
    		type: "POST",
            url: "",
            cache: !1,
            data: data,
            success: function (res) {
            	console.log(res);
            	if (res != '') 
                {
                   $('#ward').html(res);
                } else {
                    $('#ward').html('<option value="0">------</option>');
                }
            }
    	})
}

</script>
<!-- END: main -->