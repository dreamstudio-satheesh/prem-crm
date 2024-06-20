@extends('layouts.admin')

@section('pagetitle','Customer - Master-Edit Address')
     

@section('content') 



<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                            <table  border="1" class="table">
                                  <thead>
                                    <tr>
                                      <th width="2%"><input id="check_all" class="formcontrol" type="checkbox"/></th>
                                      <th width="4%">S.No</th>
                                      <th width="10%">Item</th>    
                                      <th width="10%">Qty</th>
                                      <th width="10%">Rate</th>                                    
                                      <th width="10%">Amount</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                        <th><input class="case" type="checkbox"/></th>
                                        <th> <INPUT class="form-control" type='text' readonly  id='sno_1'	 value='1'  size='4'  
                                             readonly name='sno[]'/> </th>
                                     
                                        <td> 
                                            <select style="width:300px;" class="jssingle" id='selitems1' name='selitems[]'>
                                                <option value='0'>-- Select Item --</option>
                                                  @foreach($rsitems as $department)                                                
                                                <option value='{{ $department->It_Code }}'>{{ $department->It_Name }}</option>                                              
                                                @endforeach
                                            </select>
                                        </td>                                        
                                        
                                        <td>
                                            <input type="text" value="" name="qty[]" id="qty_1" class="form-control totalQty changesNo" 
                                              autocomplete="off" onkeypress="return IsNumeric(event);" >
                                          </td>
                                        
                                        <td>
                                            <input type="text" value="" name="rate[]" id="rate_1" class="form-control changesNo" 
                                              autocomplete="off" onkeypress="return IsNumeric(event);" >
                                                   </td>
                                        
                                        <td>
                                              <input type="number"  readonly name="rowamount[]" id="rowamount_1" class="form-control totalLinePrice">
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
    
@endsection