@extends('layouts.admin')

@section('pagetitle','Customer - Master-Edit Address')
     

@section('content') 

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="customerList">



            <div class="col-md-12 col-lg-10">
                <div class="card" style="height: 80vh; overflow-y: auto;">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between">
                        <h5> Add /Edit Customer Address Book</h5>
                    </div>

                    <form action="{{ route('customers.saveaddress') }}"
                            name="registration"
                            method="post" onkeydown="return event.key != 'Enter';" class="form-horizontal form-bordered">
                            <div class="form-body">
                            <br>
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            
                                                    

                            <div style="margin-left: 0px;" class="form-group row">
                                <label for='Pty_Code' class="control-label text-left col-md-2"> Customer </label>
                                 <div class="col-md-4">
                                 @foreach($rscustomer as $customer)                        
                                        <input type="text" class="form-control" id="customer_name" 
                                         name="customer_name" readonly   value= '{{$customer->customer_name}}'>

                                         <input type="hidden" class="form-control" id="customer_code" 
                                         name="customer_code"  value= '{{$customer->customer_id}}'>
                                         @endforeach       
                                  </div> 
                            </div>
                          <br>
                           <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                            <table  border="1" class="table">
                                  <thead>
                                    <tr>
                                      <th width="2%"><input id="check_all" class="formcontrol" type="checkbox"/></th>
                                      <th width="4%">S.No</th>
                                      <th width="10%">Type</th>    
                                      <th width="10%">Contact Person</th>
                                      <th width="10%">Mobile No</th>                                    
                                      <th width="10%">Phone No</th>
                                      <th width="10%">e-Mail</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                        <th><input class="case" type="checkbox"/></th>
                                        <th> <INPUT class="form-control" type='text' readonly  id='sno_1'	 value='1'  size='4'  
                                             readonly name='sno[]'/> </th>
                                     
                                        <td> 
                                            <select style="width:300px;"  class="form-control jssingle"    id='seladdresstype1' name='seladdresstype[]'>
                                                <option value='0'>-- Select Address Type --</option>
                                                  @foreach($addresstype as $rsaddresstype)                                                
                                                <option value='{{ $rsaddresstype->id }}'>{{ $rsaddresstype->name }}</option>                                              
                                                @endforeach
                                            </select>
                                        </td>                                        
                                        
                                        <td>
                                            <input type="text" value="" name="contactperson[]" id="contactperson_1" class="form-control" 
                                              autocomplete="off"   >
                                          </td>
                                        
                                        <td>
                                            <input type="text" value="" name="mobileno[]" id="mobileno_1" class="form-control" 
                                              autocomplete="off"   >
                                                   </td>
                                        
                                        <td>
                                              <input type="text"    name="phoneno[]" id="phoneno_1" class="form-control">
                                        </td>
                                        <td>
                                              <input type="text"    name="email[]" id="email_1" class="form-control">
                                        </td>
                                        </tr>
                                       </tbody>
                                   
                             </table>   
                            
                              <div class='row'>
                                <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                                  <button class="btn btn-danger delete" type="button">- Delete</button>
                                  <button class="btn btn-success addmore" type="button">+ Add More</button>
                              </div>
                         </div>



                                                             
                        <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="offset-sm-3 col-md-7">
                                               
                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                                <a href="{{ url('transactions/purchase') }}" class="btn btn-inverse">Cancel</a>
                                            </div>
                                        </div>

                                        <br><br>
                                    </div>
                                </div>
                        </div>

                        </div>
</form>
</div>
</div>

</div>
</div>


   <script >
          
          var i=$('table tr').length;
          $(".addmore").on('click',function(){
            html = '<tr>';
            html += '<td><input class="case" type="checkbox"/></td>';
            html += '<td> <INPUT class="form-control" type="text" readonly  id="sno_'+i+'" readonly name="sno[]"/>';
            html += '<td><select style="width: 300px;" class="form-control jssingle" id="seladdresstype'+i+'"  name="seladdresstype[]"><option value="0">- Select Address Type-</option></select></td>';
              
            
            html += '<td><input type="text"  autocomplete="off" name="contactperson[]"  id="contactperson_'+i+'" class="form-control " ondrop="return false;"   onpaste="return false;"></td>';           
            html += '<td><input type="text"  autocomplete="off" name="mobileno[]" id="mobileno_'+i+'"  class="form-control" ondrop="return false;"  onpaste="return false;"><br>';
            html += '<td><input type="text"   name="phoneno[]" id="phoneno_'+i+'" class="form-control"   ></td>';
            html += '<td><input type="text"   name="email[]" id="email_'+i+'" class="form-control"   ></td>';
            html += '</tr>';
           
            updateitems('seladdresstype'+i);
            $('table').append(html);
            setrowvalue();             
            i++;
 
          $(document).on('change','#check_all',function(){	
            $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
            setrowvalue();
          });            
          
          $(".delete").on('click', function() {
            $('.case:checkbox:checked').parents("tr").remove();
            $('#check_all').prop("checked", false); 
            calculateTotal();
            setrowvalue();
          });
          
        });  
          
</script>
<script>
function setrowvalue()
          {
            
            var names = document.getElementsByName('sno[]');
            for (var j = 0, iLen = names.length; j < iLen; j++) {
                 names[j].value=j+1;
              }
          }
          
        
</script>
 

<script>

   $(document).ready(function() 
    {

          var specialKeys = new Array();
           specialKeys.push(8,46);  
           function IsNumeric(e)
            {
              var keyCode = e.which ? e.which : e.keyCode;            
              var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
              return ret;
          }
            
    });
</script>
          <script>
   
$('form input').keydown(function (e) {
  if (e.keyCode == 13) {
      e.preventDefault();
      return false;
  }
});

</script>
<script>
function updateitems(para){
              para='#'+para;
              var _token = $('input[name="_token"]').val();
                     ///////////////////////////////////
                     $.ajax({
                     url:"{{ route('fetchaddresstype') }}",
                     method:"POST", 
                     data:{_token:_token},  
                     success: function(response){                   
                      var len = response.length;
                      $(para).append(response);
                      $(para).select2();
                     },//sucess
                     error: function (jqXHR, exception) {
                  var msg = '';
                  if (jqXHR.status === 0) {
                      msg = 'Not connect.\n Verify Network.';
                  } else if (jqXHR.status == 404) {
                      msg = 'Requested page not found. [404]';
                  } else if (jqXHR.status == 500) {
                      msg = 'Internal Server Error [500].';
                  } else if (exception === 'parsererror') {
                      msg = 'Requested JSON parse failed.';
                  } else if (exception === 'timeout') {
                      msg = 'Time out error.';
                  } else if (exception === 'abort') {
                      msg = 'Ajax request aborted.';
                  } else {
                      msg = 'Uncaught Error.\n' + jqXHR.responseText;
                  }
                   alert(msg);
                 },
                 
                  headers: {
                  'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                  } 
                });
          }             
</script>
  <script>

$(document).ready(function() { $('.jssingle').select2();});

</script>     
<script>
   
$('form input').keydown(function (e) {
  if (e.keyCode == 13) {
      e.preventDefault();
      return false;
  }
});

</script>   
<script > 
$(function() {   
$("form[name='registration']").validate({    
  rules: {    
    Pty_Code: "required",  
   Net_Val: "required",  
  },
 
  messages: { 
    Pty_Code: "Please Select Customer",  
    Net_Val: "Amount Empty",  	  
  },  
  submitHandler: function(form) {
    form.submit();
  }
});
});
</script>  

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" /> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>        

    
@endsection