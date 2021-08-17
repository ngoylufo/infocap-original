<div class="row">
   <div class="col-sm-10 offset-sm-1 col-md-6 offset-md-3">

      <div id="alert"></div>
      <div class="card">

         <div class="card-body">
            <form name="Capture Form">
               <div class="row">
                  <div class="col">
                     <label for="firstName">First name</label>
                     <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First name">
                  </div>
                  <div class="col">
                     <label for="lastName">Surname</label>
                     <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Surname">
                  </div>
               </div>

               <br>

               <div class="row">
                  <div class="col">
                     <label for="birthDate">Date Of Birth</label>
                     <input type="date" id="birthDate" name="birthDate" class="form-control" placeholder="Date of Birth">
                  </div>
                  <div class="col">
                     <label for="lastName">Gender</label>
                     <select name="gender" name="gender" class="form-control" >
                        <option value="0">Rather not say</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                     </select>
                  </div>
               </div>

               <br>

               <div class="row">
                  <div class="col">
                     <label for="firstName">Email Address</label>
                     <input type="email" id="email" name="email" class="form-control" placeholder="example@mail.com">
                  </div>
                  <div class="col">
                     <label for="cellphone">Cellphone</label>
                     <input type="text" id="cellphone" name="cellphone" class="form-control" placeholder="Cellphone">
                  </div>
               </div>

               <br>

               <div class="form-group">
                  <label for="summary">Summary</label>
                  <textarea id="summary" name="summary" class="form-control" placeholder="Tell us something about yourself"rows="3"></textarea>
               </div>

               <button class="btn btn-primary ajax-submit">Submit</button>
               <button type="reset" class="btn btn-warning">Reset</button>
            </form>
         </div>
      </div>
   </div>
</div>
