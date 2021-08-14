<template>
  <section class="content">
    <div class="container-fluid">

      <div class="row">

        <div class="col-12">

          <div class="card vld-parent">
            <loading :active.sync="isLoading"
                     :can-cancel="false"
                     :is-full-page="false"></loading>
            <div class="card-header">
              <h3 class="card-title">Expense List</h3>

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
                  <th>ID</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="expense in expenses.data" :key="expense.id">

                  <td>{{ expense.id }}</td>
                  <td>{{ expense.name }}</td>
                  <td>{{ expense.description | truncate(30, '...') }}</td>
                  <td>{{ expense.category.name }}</td>
                  <td>{{ expense.price }}</td>
                  <!-- <td><img v-bind:src="'/' + expense.photo" width="100" alt="expense"></td> -->
                  <td>

                    <a href="#" @click="editModal(expense)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteExpense(expense)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <pagination :data="expenses" @pagination-change-page="getResults"></pagination>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" v-show="!editmode">Create New Expense</h5>
              <h5 class="modal-title" v-show="editmode">Edit Expense</h5>
              <button type="button" class="close" :disabled='isDisabled' data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editmode ? updateExpense() : createExpense()">
              <div class="modal-body">
                <div class="form-group">
                  <label>Name</label>
                  <input v-model="form.name" type="text" required name="name"
                         class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <input v-model="form.description" required type="text" name="description"
                         class="form-control"
                         :class="{ 'is-invalid': form.errors.has('description') }">
                  <has-error :form="form" field="description"></has-error>
                </div>
                <div class="form-group">
                  <label>Price</label>
                  <input v-model="form.price" required type="number" name="price"
                         class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                  <has-error :form="form" field="price"></has-error>
                </div>
                <div class="form-group">

                  <label>Category</label>
                  <select class="form-control" required v-model="form.category_id">
                    <option
                        v-for="(cat,index) in categories" :key="index"
                        :value="index"
                        :selected="index == form.category_id">{{ cat }}
                    </option>
                  </select>
                  <has-error :form="form" field="category_id"></has-error>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" :disabled='isDisabled' class="btn btn-secondary" data-dismiss="modal">Close</button>
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
      expenses: {},
      form: new Form({
        id: '',
        category: '',
        name: '',
        description: '',
        photo: '',
        category_id: '',
        price: '',
        photoUrl: '',
      }),
      categories: [],

      autocompleteItems: [],

      isLoading: false,
      isDisabled: false,
    }
  },
  methods: {

    getResults(page = 1) {

      this.$Progress.start();

      axios.get('api/expense?page=' + page).then(({data}) => {
        this.expenses = data.data
        this.$Progress.finish();
      });


    },
    loadExpenses() {
      // if(this.$gate.isAdmin()){
      this.isLoading = true;
      axios.get("api/expense").then(({data}) => {
        this.expenses = data.data
        this.isLoading = false;
      });

      // }
    },
    loadCategories() {
      axios.get("/api/category/list").then(({data}) => (this.categories = data.data));
    },
    editModal(expense) {
      this.editmode = true;
      this.form.reset();
      $('#addNew').modal('show');
      this.form.fill(expense);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $('#addNew').modal('show');
    },
    createExpense() {
      this.$Progress.start();
      this.isDisabled = true;
      this.form.post('api/expense')
          .then((response) => {
            if (response.data.success) {
              $('#addNew').modal('hide');

              Toast.fire({
                icon: 'success',
                title: response.data.message
              });
              this.$Progress.finish();
              this.isDisabled = false;
              this.loadExpenses();
            } else {
              Toast.fire({
                icon: 'error',
                title: 'Some error occured! Please try again'
              });
              this.isDisabled = false;
              this.$Progress.fail();
            }
          })
          .catch((data) => {
            this.isDisabled = false;
            this.$Progress.fail();
            Toast.fire({
              icon: 'error',
              title: 'Some error occured! Please try again'
            });
            Swal.fire("Failed!", data.message, "warning");
          })
    },
    updateExpense() {
      this.$Progress.start();
      this.isDisabled = true;
      this.form.put('api/expense/' + this.form.id)
          .then((response) => {
            // success
            $('#addNew').modal('hide');
            Toast.fire({
              icon: 'success',
              title: response.data.message
            });
            this.$Progress.finish();
            //  Fire.$emit('AfterCreate');

            this.loadExpenses();
            this.isDisabled = false;
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
    deleteExpense(expense) {
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
          this.$Progress.start();
          this.form.delete('api/expense/' + expense.id).then(() => {
            Swal.fire(
                'Deleted!',
                'Expense has been deleted.',
                'success'
            );
            // Fire.$emit('AfterCreate');
            this.isLoading = false;
            this.$Progress.finish();
            this.expenses.data.splice(this.expenses.data.indexOf(expense), 1);
          }).catch((data) => {
            this.isLoading = false;
            this.$Progress.fail();
            Swal.fire("Failed!", data.message, "warning");
          });
        }
      })
    },

  },
  mounted() {

  },
  created() {
    this.$Progress.start();

    this.loadExpenses();
    this.loadCategories();

    this.$Progress.finish();
  },
  filters: {
    truncate: function (text, length, suffix) {
      return text.substring(0, length) + suffix;
    },
  },
  computed: {
    filteredItems() {
      return this.autocompleteItems.filter(i => {
        return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
      });
    },
  },
}
</script>
