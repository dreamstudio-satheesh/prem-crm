@extends('layouts.admin')

@section('pagetitle','On Site Entry') 

@section('content')               
        <div class="row">
                <div class="col-12">
                        <div class="card">
                            <div class="card-block">
                                    <div class="row justify-content-between">
                                            <div class="col-4">
                                                <h4 class="card-title">Enquiry</h4>
                                            </div>
  
                                            <div class="col-6">
                                                    <div class="float-right"><a  
                                                    class="btn btn-sm  btn-primary"
                                                     href="{{ url('transactions/trnenquiry/create') }}">Add New</a></div>
                                            </div>
                                            <div class="col-12">

                                             

                                            <form  name="registration1" action="{{ url('transactions/trnenquiry/search') }}"
                                             method="post" class="form-horizontal form-bordered">
                            <div class="form-body">
                            <br>
                            <input type="hidden" name="_method" value="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <div class="col-md-3">                                    
                                      <input type="date" 
                                      name="time1" 
                                      value='{{ $rsdepartmentData["enq_date"] }}' 
                                      
                                      class="form-control">
                                                                              
                                      <input type="date" 
                                      name="time2"  
                                      value='{{ $rsdepartmentData["enq_date"] }}' 
                                      class="form-control">
                                            </div>

<div>    
   
     <input type="checkbox" id="checkcancel" name="checkcancel"   > 
     <label for="checkcancel"> Show Cancelled Trip</label>   
     <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Search</button>
    </div>
</div>
</form>
</div>
<textarea class ="message-box" name="txtmessage" id="txtmessage" rows="1"  cols="50" >Welcome!!!</textarea>
                                           
                                       
                             
                                <div class="table-responsive">
                                <table id="table_id" class="table table-bordered mb-5">
                                        <thead>
                                            <tr>
                                                
                                                <th class="text-nowrap">Edit</th>        
                                                <th>Enq Time</th>
                                                <th>Customer</th>
                                                <th>Whats App-Remarks</th>  
                                                <th>Book A Trip </th>
                                                <th>Cancel Trip </th>
                                                <th>Enquiry From</th> 
                                                <th>GST Rs 30 Extra</th> 
                                                <th>From->To</th>
                                                <th>Trip</th> 
                                                <th>Material</th> 
                                               
                                                                                     
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rsdata as $d) 
                                            <tr id="message_{{$d->enqno}}" class="table-row">
                                                
                                              
                                                <td class="text-nowrap">
                                                    <a   href="{{ url('transactions/trnenquiry/edit') }}/{{$d->enqno}}" data-toggle="tooltip" 
                                                    data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-5"> {{$d->enqno}}</i>
                                                   </a>
                                                    
                                                </td>
                                                <td>{{date('h:i A', strtotime($d->enq_time)) }}</td>
                                                <td>{{$d->Ac_Name.'->'.$d->GSTNo}}</td> 
                                                <td >
 
    <a href="whatsapp://send?text={{$d->Ac_Name}}/{{$d->placenamefrom}}->
    {{$d->placenameto}}/Contact Nos:{{$d->remarks1}}/{{$d->remarks}} "
     data-action="share/whatsapp/share">     Share via Whatsapp</a>

 

  
</td>
                                                <td>
                                                <button type="button" 
                                                data-id= "{{$d->enqno}}" 
			data-name=" {{$d->Ac_Name}}" 
            data-remarks=" {{$d->remarks}}" 	
            data-task_code=" {{$d->remarks}}"		
                                                class="btn btn-success btn-sm" style="width: 100%;" 
    data-toggle="modal" data-target="#exampleModal">Confirm Booking</button>

	  
	 </td>
     
     <td>
     <button type="button" class="btn btn-success btn-sm" 
     style="width: 100%;" data-toggle="modal" 
     data-id= "{{$d->enqno}}" 
			data-name=" {{$d->Ac_Name}}" 
            data-remarks=" {{$d->remarks}}" 	 
     data-target="#cancelModal">Cancel A Trip</button>
	   
	 </td>
                                                <td>{{$d->remarks1}}</td>
                                                <td>
                                                    <?php 
                                                    
                                                    if ($d->gstapp==0)
                                                    { echo 'YES';}
                                                    else if ($d->gstapp==1)
                                                    { echo 'NO';} 
                                                
                                                 ?></td>
                                                <td>{{$d->placenamefrom}}->{{$d->placenameto}}</td>  
                                                <td>
                                                    <?php 
                                                    
                                                    if ($d->trip==0)
                                                    { echo 'SINGLE';}
                                                    else if ($d->trip==1)
                                                    { echo 'RETURN';}

                                                    else if ($d->trip==2)
                                                    { echo 'MULTIPLE';}
                                                    
                                                
                                                 ?></td>  
                                                <td>  <?php 
                                                    
                                                    if ($d->material==0)
                                                    { echo 'CLOTH/ROLL';}
                                                    else if ($d->material==1)
                                                    { echo 'PCS';}

                                                    else if ($d->material==2)
                                                    { echo 'MACHINE';}
                                                    else if ($d->material==3)
                                                    { echo 'OTHERS';}
                                                    
                                                
                                                 ?></td>   
                                                  
                                            </tr>
                                            @endforeach
                                           
                                        </tbody>
                                    </table>

                                    {{ $rsdata->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
        </div>




<script type="text/javascript">
 
 $(document).ready(function(){
 
     $('#cancelModal').on('show.bs.modal', function (e) { 
   
         var  enqid = $(e.relatedTarget).data('id');           $('#enqid').val(enqid); 
         var  remarks = $(e.relatedTarget).data('remarks');     $('#remarks').val(remarks);
         var  acname = $(e.relatedTarget).data('name');         $('#acname').html(acname); 
     });
 });
  
 </script>


    <script>
       function savecanceltrip()
      {          
            var enqid=$('#enqid').val();	
            var remarks=$('#cancelremarks').val();	 
            var _token = $('input[name="_token"]').val();
               $.ajax
                ({
                    url:"{{ route('canceltrip') }}",
                    method:"GET",
                    data:{ enqid:enqid,_token:_token,remarks:remarks},                                  
                    success: function(response)
                    {       
                      alert(response);
                        $('#message_'+enqid).fadeOut();				
			        	$('#message_'+enqid).hide();
				        $("#txtmessage").val(response+'Sucessfully moved to Cancelled List'); 
                    } ,                       
                   headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    } 
                });
            
      }
    </script>



<div class="modal hide fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"></h4>
          </div>
          <div class="modal-body">
          

          <div   id="ids">      
               <input type="text" id="enqid"  readonly value ="" class="form-control"	 placeholder="#"> 
                   <span class="glyphicon glyphicon-lock form-control-feedback"></span>
             </div>	 
             
               <div id="acname">  <h4>   <span class="glyphicon glyphicon-lock form-control-feedback"></span></h4> </div>  
            <input type="text" id="cancelremarks" value ="" class="form-control" placeholder="Remarks"> 	 <br>   <br>    
            <button type="button" id="canceltripmodal" data-dismiss="modal" 
              class="btn btn-primary" name="canceltripmodal"
              onClick="savecanceltrip()" >   Cancel Trip
            </button> 





          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>



<div class="modal hide fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"></h4>
          </div>
          <div class="modal-body">
          <div    id="ids">      
        <input type="text" id="id"  readonly value ="" class="form-control"		 
	     	placeholder="ID"> 
               <span class="glyphicon glyphicon-lock form-control-feedback"></span>
         </div>	 
		 
		<div id="acname">  <h4>     
               <span class="glyphicon glyphicon-lock form-control-feedback"></span>
         </div> </h4>

         <input type="text" id="remarks" value ="" class="form-control"		 
	     	placeholder="Remarks">




            

			 <div class="form-group has-feedback">  

<div   class="form-group row">
                  
                    <div class="col-md-4">
                       <select class="form-control  js-example-tags" id='vehicle_code' name='vehicle_code'>
                           <option value="">-- Select Vehicle --</option>
                        </select>
                     </div> 
</div>    
<div   class="form-group row">
                  
                    <div class="col-md-4">
                       <select class="form-control  js-example-tags" id='driver_code' name='driver_code'>
                           <option value="">-- Select Driver --</option>
                        </select>
                     </div> 
</div> 
</div> 

<button type="button" id="movetoentrylevelmodal" data-dismiss="modal" 
class="btn btn-primary" name="movetoentrylevelmodal"
onClick="savefrn()" >   Confirm Booking
</button> 
          </div>
 

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
 
  

 
   

    <!-- Begin page content -->
    
          <!-- Begin page content -->

    <script>
       function savefrn()
      {
          
            var id=$('#id').val();	
            
            var vehicle_code = $('#vehicle_code').find(":selected").val();
            var driver_code = $('#driver_code').find(":selected").val();
             
            var _token = $('input[name="_token"]').val();
               $.ajax
                ({
                    url:"{{ route('savebooking') }}",
                    method:"GET",
                    data:{ id:id,_token:_token,vehicle_code:vehicle_code,driver_code:driver_code},                                  
                    success: function(response)
                    {       
                      alert(response);
                        $('#message_'+id).fadeOut();				
			        	$('#message_'+id).hide();
				        $("#txtmessage").val(response+'Sucessfully moved to Task List');
                     // $('#exampleModal').modal('toggle'); 
                    } ,                       
                   headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    } 
                });
            
      }
    </script>


<script type="text/javascript">
 
$(document).ready(function(){

    $('#exampleModal').on('show.bs.modal', function (e) {  
        var  id = $(e.relatedTarget).data('id');                $('#id').val(id); 
		var  remarks = $(e.relatedTarget).data('remarks');      $('#remarks').val(remarks);
        var  acname = $(e.relatedTarget).data('name');          $('#acname').html(acname);
        updateselect2();
        selectdriver();
    });
});
 
</script>
 <script>
    function updateselect2( ){
    
    var _token = $('input[name="_token"]').val();
          
           $.ajax({
           url:"{{ route('getvehicle') }}",
           method:"GET", 
           data:{_token:_token},  
           success: function(response){                   
            var len = response.length;
           
            $('#vehicle_code').append(response);
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


function selectdriver( ){
    
    var _token = $('input[name="_token"]').val();
          
           $.ajax({
           url:"{{ route('getdriver') }}",
           method:"GET", 
           data:{_token:_token},  
           success: function(response){                   
            var len = response.length;
           
            $('#driver_code').append(response);
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
  
  $(document).ready(function() 
  { 
      $('#table_id').DataTable( {
        order: [[0, 'desc']],  
        dom: 'Bfrtip',
        "lengthMenu": [100,10,50,100,200,500,1000,2000,10000],
          buttons: [
            'pageLength', 'copy', 'csv', 'excel', 'pdf', 'print'
          ]
      } );
  } ); 
  </script>  

<script> 
    $('#edit-modal').on('show.bs.modal', function(e) {
       
        $('#welcome').html('');
        var  id = $(e.relatedTarget).data('id');  
        $('#inw_no').val(id);
            var html='';
            html +='<div class="table-responsive  m-t-40">';
            html +='<table id="myTable" class="table table-bordered table-striped">';
            html +='<tr> <th  width="5%">S.No</th> <th  width="5%" >Colour</th> ';
            html +=' <th  width="5%">Fabric</th>';
            html +='<th width="5%" >FRN</th>';
            html +='<th width="5%" >Bill.Weight</th>';
            html +='<th width="5%" >Recd.Weight</th>';
            html +='</tr>';
            html +='';
              
                                    
        //    $("#modal-input-id").val('welcome');
            updatecolour(id);
           
        
    //////////////////////////////////////////////////////////////////////////////   
            function updatecolour(id)
            {
                var _token = $('input[name="_token"]').val();
                $.ajax
                ({
                    url:"{{ route('fetchfrn') }}",
                    method:"POST", 
                    data:{_token:_token,id:id},  
                    success: function(response)
                    {           
                       $.each(response,function(index)
                       {
                        var x = parseFloat(response[index].weight);
                        

    html +='<tr>';
    html +='<td>'+response[index].indx+' <input type="hidden" class="sno" name="sno[]" value="'+response[index].indx+'"/></td>';
    html +='<td>'+response[index].coloursname+'<input type="hidden"   name="colourname[]"  value="'+response[index].coloursid+'"/></td>';
    html +='<td>'+response[index].fabricsname+'<input type="hidden"  name="fabricname[]"  value="'+response[index].fabricsid+'"/></td>';
    html +='<td><input type="text"  name="frnnumber[]"  value="'+response[index].frnnumber+'"/></td>';
    html +='<td>'+response[index].weight+'</td>';
    html +='<td><input type="number"  style=" width: 100px;"  name="recdweight[]"   value="'+response[index].delivery_weight+'"/></td>';
    html +='</tr>';
                           
                       })   
                       html +='</tbody> </table> </div>';     
                       $('#welcome').append(html);   
                    },
                    ////////////////////////////////////////////////////////////////////////////// 
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
                     //////////////////////////////////////////////////////////////////////////////       
                   headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    } 
                });
            }
    //////////////////////////////////////////////////////////////////////////////        
    });


</script>        
@endsection
