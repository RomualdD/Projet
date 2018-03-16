                                <div class="modal fade" id="modalAppointment" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h3 class="modal-title"><i class="fa fa-info" aria-hidden="true"></i> <?php echo MODALTITLEAPPOINTMENT; ?></h3>
                                            </div>
                                            <div class="modal-body">
                                              <div class="row">
                                                  <div class="col-lg-offset-1 col-lg-11">
                                                    <label for="nameappointment"><?php echo NAMEAPPOINTMENT; ?> </label><input class="col-lg-offset-1" type="text" name="nameappointmentforModif" id="nameappointment" disabled>
                                                    <label for="hourappointment"><?php echo HOURAPPOINTMENT; ?></label><input type="text" class="col-lg-offset-1" name="hourappointmentforModif" id="hourappointment" disabled>
                                                    <label for="informationappointment"><?php echo INFORMATIONAPPOINTMENT; ?> </label><textarea class="form-control" rows="5" cols="10" type="text" name="infoappointmentforModif" id="infoappointment" disabled></textarea> 
                                                    <input type="text" class="col-lg-offset-1" id="id" disabled hidden>
                                                  </div>
                                              </div>
                                              <hr>
                                              <div class="row">
                                                  <div class="col-lg-11">
                                                     <h3 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo EDITMODALAPPOINTMENT; ?></h3>
                                                  </div>
                                              </div>
                                                <div class="row">
                                                    <div class="col-lg-offset-1">
                                                        <form action="rendez-vous" method="POST">
                                                            <div class="col-lg-12">
                                                                <div class="form-inline">
                                                                    <label for="nameappointment"><?php echo NAMEAPPOINTMENT; ?> </label>
                                                                    <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10" id="name">
                                                                        <span class="input-group-addon"><i class="fa fa-address-book-o" aria-hidden="true"></i></span>
                                                                        <input type="text" class="form-control" id="newnameappointment" name="nameappoitmentmodif" placeholder="<?php echo NAMEAPPOINTMENTPLACEHOLDER; ?>">
                                                                    </div>
                                                                    <p class="errormessage col-lg-offset-3 col-lg-9" id="errorNomMessageModal"><?php echo INCORRECTNAME; ?></p>
                                                                </div> 
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-inline">
                                                                    <label for="dayappointment"><?php echo DAYAPPOINTMENT; ?> </label>
                                                                    <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10" id="date">
                                                                        <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                                        <input type="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" id="day" name="dayappointmentmodif">
                                                                    </div>
                                                                    <p class="errormessage col-lg-offset-3 col-lg-9" id="errorDayMessageModal"><?php echo INCORRECTDATE; ?></p>
                                                                </div> 
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-inline">
                                                                    <label for="hourappointment"><?php echo HOURAPPOINTMENT; ?></label>
                                                                    <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10" id="hour">
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                                                        <input type="time" class="form-control" id="hour" name="hourappointmentmodif" placeholder="<?php echo date('H:i'); ?>">
                                                                    </div>
                                                                    <p class="errormessage col-lg-offset-3 col-lg-9" id="errorHourMessageModal"><?php echo ERRORHOURAPPOINTMENT; ?></p>
                                                                </div> 
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-inline">
                                                                    <div class="input-group" id="subject">
                                                                        <label for="informationappointment"><?php echo INFORMATIONAPPOINTMENT; ?> </label>
                                                                        <textarea class="form-control" id="info" rows="5" cols="10" placeholder="<?php echo INFORMATIONAPPOINTMENTPLACEHOLDER; ?>" name="infosappointmentmodif"><?php //echo $informations['infoappointment'];?></textarea>
                                                                    </div>
                                                                    <p class="errormessage col-lg-offset-3 col-lg-9" id="errorInfoMessageModal"><?php echo ERRORCOMPLEMENTARYINFORMATIONS; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-offset-3 col-lg-2" id="modifButton">
                                                                <div class="form-inline">
                                                                  <input id="submitmodif" type="button" value="<?php echo EDIT; ?>" class="button btn btn-default col-lg-offset-4 col-xs-offset-4">                        
                                                                </div>
                                                            </div>
                                                            <p class="errormessage col-lg-offset-1 col-lg-9" id="totalerror"><?php echo ERRORINFORMATIONS; ?></p>
                                                        </form>
                                                    </div>
                                                </div>
                                              <hr>
                                              <div class="row">
                                                  <div class="row">
                                                    <div class="col-lg-offset-1 col-lg-11">
                                                        <form method="POST" action="rendez-vous">
                                                          <div class="col-lg-offset-3 col-lg-2">
                                                              <div class="form-inline">
                                                                  <input id="submitdelete" type="submit" value="<?php echo DELETEBUTTON; ?>" class="button btn btn-danger col-lg-offset-4 col-xs-offset-4" name="submitdelete">                        
                                                              </div>
                                                          </div>
                                                        </form>
                                                    </div>
                                                  </div>
                                              </div>                                                                                
                                            </div>
                                            <div class="modal-footer">
                                             <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo CLOSE; ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modalAppointmentUp" role="dialog">
                                    <div class="modal-dialog">
                                      <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h3 class="modal-title"><i class="fa fa-info" aria-hidden="true"></i> <?php echo MODALTITLEAPPOINTMENT; ?></h3>
                                            </div>
                                            <div class="modal-body">
                                              <div class="row">
                                                  <div class="col-lg-offset-1 col-lg-11">
                                                    <label for="nameappointment"><?php echo NAMEAPPOINTMENT; ?> </label><input class="col-lg-offset-1" type="text" name="nameappointmentforModif" id="nameappointmentUp" disabled>
                                                    <label for="hourappointment"><?php echo HOURAPPOINTMENT; ?></label><input type="text" class="col-lg-offset-1" name="hourappointmentforModif" id="hourappointmentUp" disabled>
                                                    <label for="informationappointment"><?php echo INFORMATIONAPPOINTMENT; ?> </label><textarea class="form-control" rows="5" cols="10" type="text" name="infoappointmentforModif" id="infoappointmentUp" disabled></textarea> 
                                                    <input type="text" class="col-lg-offset-1" name="idforModif" id="id" disabled hidden>                                                  
                                                  </div>
                                              </div>
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <h3 id="remarqueTitle" class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo ADDREMARQUEAPPOINTMENT; ?></h3>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-offset-1 col-lg-11">
                                                            <form method="POST" action="rendez-vous">
                                                                <div class="col-lg-12">
                                                                    <div class="form-inline">
                                                                        <div class="input-group subject">
                                                                            <label for="remarqueappointment"><?php echo REMARQUEAPPOINTMENT; ?> </label>
                                                                            <textarea class="form-control" id="remarqueappointment" rows="5" cols="10" placeholder="<?php echo REMARQUEAPPOINTMENTPLACEHOLDER; ?>" name="remarqueappointment"><?php echo $informations['remarque']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-offset-3 col-lg-2">
                                                                     <div class="form-inline">
                                                                        <input id="submitremarqueadd" type="submit" value="<?php echo ADDBUTTON; ?>" class="button btn btn-default col-lg-offset-4 col-xs-offset-4" name="submitremarqueadd">                        
                                                                    </div>
                                                                    <p class="errormessage col-lg-offset-3 col-lg-9" id="errorMessageModal"><?php echo INCORRECTNAME; ?></p>
                                                                </div>                                                                    
                                                            </form>
                                                        </div>
                                                    </div>    
                                                </div>                                         
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo CLOSE; ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
