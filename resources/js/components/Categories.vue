<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-12">

          <div class="card vld-parent" v-if="$gate.isAdmin()">
            <loading :active.sync="isLoading"
                     :can-cancel="false"
                     :is-full-page="false"></loading>
            <div class="card-header">
              <h3 class="card-title">Category List</h3>

              <div class="card-tools">

                <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                  <i class="fa fa-plus-square"></i>
                  Add New
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="category in categories.data" :key="category.id">

                  <td class="text-capitalize">{{ category.name }}</td>
                  <td>{{ category.description }}</td>
                  <td>

                    <a href="#" @click="editModal(category)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteCategory(category)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <pagination :data="categories" @pagination-change-page="getResults"></pagination>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>


      <div v-if="!$gate.isAdmin()">
        <not-found></not-found>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" v-show="!editmode">Create New Category</h5>
              <h5 class="modal-title" v-show="editmode">Update Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <!-- <form @submit.prevent="createUser"> -->

            <form @submit.prevent="editmode ? updateCategory() : createCategory()">
              <div class="modal-body">
                <div class="form-group">
                  <label>Name</label>
                  <input v-model="form.name" type="text" name="name"
                         required class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <input v-model="form.description" type="text" name="description"
                         class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                  <has-error :form="form" field="description"></has-error>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" :disabled='isDisabled' class="btn btn-secondary" data-dismiss="modal">Close
                </button>
                <button v-show="editmode" :disabled='isDisabled' type="submit" class="btn btn-success">Update</button>
                <button v-show="!editmode" :disabled='isDisabled' type="submit" class="btn btn-primary">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Loading from 'vue-loading-overlay';

export default {
  components: {
    Loading
  },
  data() {
    return {
      editmode: false,
      categories: {},
      form: new Form({
        id: '',
        name: '',
        description: '',
      }),

      isLoading: false,
      isDisabled: false,
    }
  },
  methods: {

    getResults(page = 1) {

      this.$Progress.start();

      axios.get('/api/category?page=' + page).then(({data}) => (this.categories = data.data));

      this.$Progress.finish();
    },
    updateCategory() {
      this.isDisabled = true;
      this.$Progress.start();
      this.form.put('/api/category/' + this.form.id)
          .then((response) => {
            // success
            $('#addNew').modal('hide');
            Toast.fire({
              icon: 'success',
              title: response.data.message
            });
            this.$Progress.finish();
            //  Fire.$emit('AfterCreate');

            this.isDisabled = false;
            this.loadCategories();
          })
          .catch(() => {
            this.isDisabled = false;
            this.$Progress.fail();
            Toast.fire({
              icon: 'error',
              title: 'Some error occured! Please try again'
            });
          });

    },
    editModal(category) {
      this.editmode = true;
      this.form.reset();
      $('#addNew').modal('show');
      this.form.fill(category);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $('#addNew').modal('show');
    },

    loadCategories() {
      this.isLoading = true;
      if (this.$gate.isAdmin()) {
        axios.get("/api/category").then(({data}) => {
          this.categories = data.data
          this.isLoading = false
        });
      }
    },

    createCategory() {
      this.isDisabled = true;
      this.$Progress.start();
      this.form.post('/api/category')
          .then((response) => {
            $('#addNew').modal('hide');

            Toast.fire({
              icon: 'success',
              title: response.data.message
            });

            this.$Progress.finish();
            this.isDisabled = false;
            this.loadCategories();
          })
          .catch(() => {
            this.isDisabled = false;
            this.$Progress.fail();
            Toast.fire({
              icon: 'error',
              title: 'Some error occured! Please try again'
            });
          })
    },

    deleteCategory(category) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes'
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          this.isLoading = true;
          this.form.delete('/api/category/' + category.id).then(() => {
            Swal.fire(
                'Deleted!',
                'Category has been deleted.',
                'success'
            );
            // Fire.$emit('AfterCreate');
            this.isLoading = false;
            this.categories.data.splice(this.categories.data.indexOf(category), 1);
          }).catch((data) => {
            this.isLoading = false;
            Swal.fire("Failed!", data.message, "warning");
          });
        }
      })
    },

  },
  mounted() {
    console.log('Component mounted.')
  },
  created() {

    this.$Progress.start();
    this.loadCategories();
    this.$Progress.finish();
  }
}
</script>
