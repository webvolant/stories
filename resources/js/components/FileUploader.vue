<template>
  <div>
    id: {{id}}<br/>
    <vue-dropzone
      ref="myVueDropzone"
      id="dropzone"
      :options="dropzoneOptions"
      :useCustomSlot="false"
      v-on:vdropzone-success="uploadSuccess"
      v-on:vdropzone-error="uploadError"
      v-on:vdropzone-removed-file="fileRemoved"
    >
      <div class="dropzone-custom-content">
        <h3 class="dropzone-custom-title">Drag and drop to upload content!</h3>
        <div class="subtitle">...or click to select a file from your computer</div>
      </div>
    </vue-dropzone>
    <div class="list-group" style="margin-top: 15px">
          <span v-for="(item, index) in filesUploaded" class="list-group-item list-group-item-action">
            <img :src="item.path" width="40px"/>
            {{ item.name }}
            <button type="button" @click="myRemoveFile(item.id)" class="btn btn-secondary pull-right">x</button>
          </span>
    </div>
  </div>
</template>

<script>
	import vue2Dropzone from "vue2-dropzone";
	import "vue2-dropzone/dist/vue2Dropzone.min.css";
	export default {
		components: {
			vueDropzone: vue2Dropzone
		},
		props: {
			id: null,/*{
				type: Object
			}*/
		},
		data() {
			return {
				dropzoneOptions: {
					url: "/api/files",
					addRemoveLinks: true,
					//maxFiles: 1
					uploadMultiple:true,
					parallelUploads:10,
					params: {
						id:this.id,
					}
				},
				filesUploaded: [],
			};
		},
		mounted(){
			this.getNotAssignedFiles()
			console.log('uploader init4')
		},
		methods: {
			uploadSuccess(file, response) {
				console.log('File Successfully Uploaded with file name: ' + response.files);
				this.filesUploaded = response.files;

				this.getNotAssignedFiles();

			},
			uploadError(file, message) {
				console.log('An Error Occurred');
			},
			fileRemoved() {},
			getNotAssignedFiles(){
				let that = this;
				axios.post('/api/getFiles', {id:this.id}).then((response) => {
					console.log(response)
					that.filesUploaded = response.data.files
				}).catch((e) => {
					console.log(e)
				})
			},
			myRemoveFile(id){
				let that = this;
				axios.get('/api/removeFile',{ params: {id:id} }).then((response) => {
					console.log(response)
					that.getNotAssignedFiles();
					//that.filesUploaded = response.data.files
				}).catch((e) => {
					console.log(e)
				})

			},
		}
	};
</script>
