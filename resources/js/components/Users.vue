<template>
  <div class="container">
    <div v-if="$gate.isAdminOrSuperAdmin()" class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users</h3>
            <div class="card-tools">
              <button class="btn btn-success"
              @click.prevent="newModal">
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
                  <td>{{ user.type | upText }}</td>
                  <td>{{ user.created_at | myDate }}</td>
                  <td>
                    <a href="" class="btn btn-primary" role="button"
                    @click.prevent="editModal(user)">
                      <i class="fa fa-edit"></i>
                      <span>Edit</span>
                    </a>
                    <a href="" class="btn btn-danger" role="button"
                    @click.prevent="deleteUser(user.id)">
                      <!-- <i class="fa fa-trash red"></i> -->
                      <i class="fa fa-times white"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div v-if="!$gate.isAdminOrSuperAdmin()">
      <not-found></not-found>
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
            <h5 class="modal-title" id="addNewLabel">{{ !editMode ? 'Add New' : 'Edit User' }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="!editMode ? createUser() : updateUser()">
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
              <button type="submit" class="btn btn-primary">{{ !editMode ? 'Create' : 'Update' }}</button>
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
          id: '',
          name: '',
          email: '',
          password: '',
          type: '',
          bio: '',
          photo: '',
      }),
      editMode: false
    };
  },
  created() {
    console.log("Component mounted.");
    this.loadUsers();
  },
  methods: {
    newModal() {
      this.editMode = false;
      this.form.reset();
      $('#addNew').modal('show');
    },
    editModal(user) {
      this.editMode = true;
      this.form.reset();
      $('#addNew').modal('show');
      this.form.fill(user);
    },
    loadUsers() {
        if (this.$gate.isAdminOrSuperAdmin()) {
            axios.get('api/user')
            .then(({ data }) => {
                this.users = data.data;
            }).catch((err) => {

            });
        };
    },
    createUser() {
        // starting progress bar
        this.$Progress.start();
        // sending via vForm
        this.form.post('api/user')
        .then((res) => {
            // finishing progress bar on create
            this.$Progress.finish();
            // Swal: disparando toast
            Toast.fire({
                type: 'success',
                title: 'Created in successfully'
            });
            // Fechando modal
            $('#addNew').modal('hide');
            this.loadUsers();
        }).catch((err) => {
            console.error(err);
            // finishing progress bar on error
            this.$Progress.fail();
            Toast.fire({
                type: 'error',
                title: 'Cannot be created'
            });
        });
    },
    updateUser() {
        this.$Progress.start();
        var id = this.form.id;
        this.form.put('api/user/' + id)
        .then((result) => {
            this.$Progress.finish();
            Toast.fire({
                type: 'success',
                title: 'Updated in successfully'
            });
            $('#addNew').modal('hide');
            this.loadUsers();
        }).catch((err) => {
            this.$Progress.fail();
        });
    },
    deleteUser(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        // if confirm delete do
        if (result.value) {
          // Send request to the server
          axios.delete('api/user/' + id)
          .then((result) => {
            // if deleted
            Swal.fire(
            'Deleted!',
            'The user has been deleted.',
            'success'
            );
            this.loadUsers();
          })
          .catch((err) => {
            console.log(err.response.data.message);
            Swal.fire(
                'Error',
                'Cannot be deleted. ' + err.response.data.message,
                'error'
            )
          });
        }
      });
    }
  }
};
</script>
