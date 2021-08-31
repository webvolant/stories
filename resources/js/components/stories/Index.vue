<template>
  <div>
    <div class="container">
      <h2>Items</h2>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <a href="/admin/create" class="btn btn-primary pull-right">Добавить</a>
        </div>
        <div class="panel-body">
          <table class="table">
            <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in data" :key="item.id">
              <td>{{ item.id }}</td>
              <td>{{ item.title }}</td>
              <!--<td><a :href="'/admin/edit/'+item.id">edit</a>-->
              <td>
                <a :href="routeEdit+'/'+item.id" class="btn btn-secondary">Редактировать</a>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
	export default {
		props: {
			items: { type: Array },
			routeEdit: { type: String },
		},
		data() {
			return {
				data: [],
			};
		},
		created() {
			axios.get("https://storyme.org/api/items").then((response) => {
          this.data = response.data;
      });
		},
		methods: {
			/*deleteStudent(id) {
          this.axios
              .delete(`http://localhost:8000/api/students/${id}`)
              .then((response) => {
                  let i = this.students.map((data) => data.id).indexOf(id);
                  this.students.splice(i, 1);
              });
      },*/
		},
	};
</script>
