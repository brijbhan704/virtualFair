@php
$i=1
@endphp
@foreach($leadList as $list)

                                      <tr>
                                          <th scope="row">{{$i++}}</th>
                                         
                                          <td>{{ucfirst($list->lm_fullname)}}
                                                 <div>{{$list->cm_name}} </div></td>
                                          <td>{{ucfirst($list->qm_text)}}
                                                <div>{{$list->pm_text}} </div></td>
                                          <td>{{$list->lm_email}}
                                                <div> {{$list->lm_mobile}} </div></td>
                                          <td><ul>{!! $list->activity !!}</ul></td>

                                          <td scope="row">{{date('M-d, Y',strtotime($list->leem_datetime))}}
                                                <div> {{date('h:i A',strtotime($list->leem_datetime))}}</div></td>

                                          <td> 
                                                <span class="badge badge-pill badge-outline-primary p-1 m-1" id="status{{$list->leem_id}}" >{{$list->lc_text}} </span>
                                                <a href="javascript:void(0);" class="text-success mr-2" onclick="addcate('{{$list->leem_id}}');"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>


                                                <div class="divide">
                                                <span class="btn p-1 m-1"  onclick="showhistory('{{$list->leem_id}}');" >View History</span></div>
                                          </td>
                                      </tr>

@endforeach
