

                                        @php
                                        $i=1
                                        @endphp
                                        @foreach($leadList as $list)

                                                                              <tr>
                                                                                  <th scope="row">{{$i++}}</th>

                                                                                  <td>{{$list->lm_fullname}}</td>
                                                                                  <td>{{$list->cm_name}}</td>
                                                                                  <td>{{$list->qm_text}}</td>
                                                                                  <td>{{$list->pm_text}}</td>
                                                                                  <td></td>
                                                                                  <td></td>
                                                                                  <td></td>
                                                                                  <td></td>
                                                                                  <td></td>
                                                                              </tr>

                                        @endforeach
