<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users</h3>
            <div class="card-tools">
                <button class="btn btn-success"><i class="fa fa-user-plus pr-2"></i><span>New User</span></button>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                  <tbody>
                      <tr>
                          <th>ID</th>
                          <th>Email</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Action</th>
                      </tr>
                      <tr>
                          <td>183</td>
                          <td>Maximo Henrique</td>
                          <td>01-01-2001</td>
                          <td><span class="tag tag-success">Approved</span></td>
                          <td>
                              <a href=""><i class="fa fa-edit blue"></i></a>
                              <a href=""><i class="fa fa-trash red"></i></a>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
