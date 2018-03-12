                                <div class="modal fade" id="modalAppointment" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h3 class="modal-title"><i class="fa fa-info" aria-hidden="true"></i> Informations de ce rendez-vous :</h3>
                                            </div>
                                            <div class="modal-body">
                                              <div class="row">
                                                  <div class="col-lg-offset-1 col-lg-11">
                                                    <label for="nameappointment">Nom du rendez-vous : </label><input class="col-lg-offset-1" type="text" name="nameappointmentforModif" id="nameappointment" disabled>
                                                    <label for="hourappointment">Horaire consultation :</label><input type="text" class="col-lg-offset-1" name="hourappointmentforModif" id="hourappointment" disabled>
                                                    <label for="informationappointment">Informations complémentaires du rendez-vous : </label><textarea class="form-control" rows="5" cols="10" type="text" name="infoappointmentforModif" id="infoappointment" disabled></textarea> 
                                                    <input type="text" class="col-lg-offset-1" id="id" disabled hidden>
                                                  </div>
                                              </div>
                                              <hr>
                                              <div class="row">
                                                  <div class="col-lg-11">
                                                     <h3 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modifier ce rendez-vous :</h3>
                                                  </div>
                                              </div>
                                                <div class="row">
                                                    <div class="col-lg-offset-1">
                                                        <form action="rendez-vous" method="POST">
                                                            <div class="col-lg-12">
                                                                <div class="form-inline">
                                                                    <label for="nameappointment">Nom du rendez-vous : </label>
                                                                    <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10" id="name">
                                                                        <span class="input-group-addon"><i class="fa fa-address-book-o" aria-hidden="true"></i></span>
                                                                        <input type="text" class="form-control" id="newnameappointment" name="nameappoitmentmodif" placeholder="Médecin">
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-inline">
                                                                    <label for="dayappointment">Jour du rendez-vous : </label>
                                                                    <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10" id="date">
                                                                        <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                                        <input type="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" id="day" name="dayappointmentmodif">
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-inline">
                                                                    <label for="hourappointment">Horaire consultation :</label>
                                                                    <div class="input-group mail col-lg-offset-1 col-lg-4 col-sm-4 col-md-4 col-xs-10" id="hour">
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                                                        <input type="time" class="form-control" id="hour" name="hourappointmentmodif" placeholder="<?php echo date('H:i'); ?>">
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-inline">
                                                                    <div class="input-group" id="subject">
                                                                        <label for="informationappointment">Informations complémentaires du rendez-vous : </label>
                                                                        <textarea class="form-control" id="info" rows="5" cols="10" placeholder="Informations supplémentaires" name="infosappointmentmodif"><?php //echo $informations['infoappointment'];?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-offset-3 col-lg-2" id="modifButton">
                                                                <div class="form-inline">
                                                                  <input id="submitmodif" type="button" value="Modifier !" class="button btn btn-default col-lg-offset-4" >                        
                                                                </div>
                                                            </div>
                                                           <!-- <p class="errormessage col-lg-offset-1 col-lg-9" id="errorMessageModal" hidden>Plusieurs informations sont incorrectes !</p>-->
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
                                                                  <input id="submitdelete" type="submit" value="Supprimer !" class="button btn btn-danger col-lg-offset-4" name="submitdelete">                        
                                                              </div>
                                                          </div>
                                                        </form>
                                                    </div>
                                                  </div>
                                              </div>                                                                                
                                            </div>
                                            <div class="modal-footer">
                                             <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fermer</button>
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
                                              <h3 class="modal-title"><i class="fa fa-info" aria-hidden="true"></i> Informations de ce rendez-vous :</h3>
                                            </div>
                                            <div class="modal-body">
                                              <div class="row">
                                                  <div class="col-lg-offset-1 col-lg-11">
                                                    <label for="nameappointment">Nom du rendez-vous : </label><input class="col-lg-offset-1" type="text" name="nameappointmentforModif" id="nameappointmentUp" disabled>
                                                    <label for="hourappointment">Horaire consultation :</label><input type="text" class="col-lg-offset-1" name="hourappointmentforModif" id="hourappointmentUp" disabled>
                                                    <label for="informationappointment">Informations complémentaires du rendez-vous : </label><textarea class="form-control" rows="5" cols="10" type="text" name="infoappointmentforModif" id="infoappointmentUp" disabled></textarea> 
                                                    <input type="text" class="col-lg-offset-1" name="idforModif" id="id" disabled hidden>                                                  
                                                  </div>
                                              </div>
                                                <div class="row">
                                                    <div class="col-lg-11">
                                                        <h3 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ajouter une note à ce rendez-vous :</h3>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-offset-1 col-lg-11">
                                                            <form method="POST" action="rendez-vous">
                                                                <div class="col-lg-12">
                                                                    <div class="form-inline">
                                                                        <div class="input-group subject">
                                                                            <label for="remarqueappointment">Note complémentaire du rendez-vous : </label>
                                                                            <textarea class="form-control" id="remarqueappointment" rows="5" cols="10" placeholder="Notes complémentaire" name="remarqueappointment"><?php// echo $informations['remarque']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-offset-3 col-lg-2">
                                                                     <div class="form-inline">
                                                                        <input id="submitremarqueadd" type="submit" value="Ajouter !" class="button btn btn-default col-lg-offset-4" name="submitremarqueadd">                        
                                                                    </div>
                                                                    <p class="errormessage col-lg-offset-3 col-lg-9" id="errorMessageModal" hidden>Nom incorrect !</p>
                                                                </div>                                                                    
                                                            </form>
                                                        </div>
                                                    </div>    
                                                </div>                                         
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
