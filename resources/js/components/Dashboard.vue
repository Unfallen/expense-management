<template>
  <section class="content">
    <div class="container-fluid">
      <!-- /.row -->

      <div class="row">
        <!-- Left col -->
        <div class="col-md-10 offset-md-1">
          <!-- MAP & BOX PANE -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Expenses Chart</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <BarChart></BarChart>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
</template>

<script>
import BarChart from './expense/ExpenseChart.vue'

export default {
  components: {
    BarChart
  },
  async mounted() {

  }
}
</script>
