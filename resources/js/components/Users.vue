<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users</h3>
            <div class="card-tools">
              <button class="btn btn-success" data-toggle="modal" data-target="#addNew">
                <i class="fa fa-user-plus pr-2"></i>
                <span>New User</span>
              </button>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Registered at</th>
                  <th>Action</th>
                </tr>
                <tr v-for="user in users" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.type }}</td>
                  <td>{{ user.created_at }}</td>
                  <td>
                    <a href>
                      <i class="fa fa-edit blue"></i>
                    </a>
                    <a href>
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewLabel">Add New</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="createUser">
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Name"
                    :class="{ 'is-invalid': form.errors.has('name') }"
                    v-model="form.name"
                    >
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Email Address"
                    :class="{ 'is-invalid': form.errors.has('email') }"
                    v-model="form.email"
                    >
                    <has-error :form="form" field="email"></has-error>
                </div>
                <div class="form-group">
                    <textarea type="text" name="bio" class="form-control" placeholder="Short bio for user (optional)"
                    :class="{ 'is-invalid': form.errors.has('bio') }"
                    v-model="form.bio"
                    ></textarea>
                    <has-error :form="form" field="bio"></has-error>
                </div>
                <div class="form-group">
                    <select type="text" name="type" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('type') }"
                    v-model="form.type"
                    >
                      <option value="">Select User Role</option>
                      <option value="admin">Admin</option>
                      <option value="user">Standard User</option>
                      <option value="author">Author</option>
                    </select>
                    <has-error :form="form" field="type"></has-error>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password"
                    :class="{ 'is-invalid': form.errors.has('password') }"
                    v-model="form.password"
                    >
                    <has-error :form="form" field="password"></has-error>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: {},
      form: new Form({
          name: '',
          email: '',
          password: '',
          type: '',
          bio: '',
          photo: '',
      })
    };
  },
  created() {
    console.log("Component mounted.");
    this.loadUsers();
  },
  methods: {
    loadUsers() {
        axios.get('api/user')
        .then(({ data }) => {
            this.users = data.data;
        }).catch((err) => {

        });
    },
    createUser() {
      // sending via vForm
      this.form.post('api/user')
      .then((res) => {
          console.log(res);
      }).catch((err) => {
          console.error(err)
      });
    }
  }
};
</script>
