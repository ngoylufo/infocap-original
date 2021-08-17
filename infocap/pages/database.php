<!-- Modal -->
<div class="modal fade" id="personModal" tabindex="-1" role="dialog" aria-labelledby="personModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="personModalLabel">Personal Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
    </div>
  </div>
</div>

<div class="row">
   <div class="col-8 offset-2">
        <div id="alert"></div>
        <form name="Sorting Form" class="form-inline-block">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="order">Order</label>
                        </div>

                        <select name="order" id="order" class="custom-select" data-toggle="tooltip" title="Redorders table asynchronously on change!">
                            <option value="ASC">Ascending</option>
                            <option value="DESC">Descending</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 col-md-2 px-0">
                    <button class="btn ajax-submit text-info">Click on the headers to specify which column to sort by.</button>
                </div>
            </div>
        </form>

        <br>

        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped table-hover text-center m-0">
                    <!-- <caption class="text-center">People</caption> -->
                    <thead>
                        <tr>
                            <th class="sorter" js-column="id" sorting="false">#ID</th>
                            <th class="sorter" js-column="lastName" sorting="false">Surname, Name</th>
                            <th class="sorter" js-column="gender" sorting="false">Gender</th>
                            <th class="sorter" js-column="recDate" sorting="false">Date Recorded</th>
                        </tr>
                    </thead>
                    <tbody id="ajax-people" class="ajax-output">
                    </tbody>
                </table>
            </div>
        </div>
        <br>

        <ul id="#pagination" class="pagination ajax-pagination">

        </ul>
   </div>
</div>
