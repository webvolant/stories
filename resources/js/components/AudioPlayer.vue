<template>
  <div class="q-col-gutter-xs" style="border: 1px solid #dee2e6; padding: 10px 10px;"> <!-- style="display: none;" preload="auto" -->
    <div class="row">
      <div class="col px-4 py-3">
        <audio ref="audio" :src="file.path">
          <!--<source src="audio/patrul-0.mp3" type="audio/mpeg">
          Your browser does not support the audio element.-->
        </audio>
        <Slider v-model="currentSeconds" :min="0" :max="durationSeconds" @input="seek"></Slider>
        <!--<-slider v-model="currentSeconds" :min="0" :max="durationSeconds" @change="seek"/>-->
      </div>
      <!-- если есть начатый прослушанный то просто из сесси подгружаем его в окне дополнительном внизу -->
    </div>

    <div class="row mt-3">
      <div class="col-3">
        <div class="player-time-current text-start" style="margin-top: 5px; font-size: 18px;">{{ convertTime(currentSeconds) }}</div>
      </div>
      <div class="col-6 text-center">
        <a class="btn btn-outline-primary" @click="prev()" icon="fas fa-angle-double-left" ><i class="pi pi-angle-double-left"></i></a>
        <button @click="play()" v-if="!playing" class="btn btn-primary" style="padding: 10px 15px;"><i class="pi pi-play" style="font-size: 40px;"></i></button>
        <button @click="pause()" v-if="playing" class="btn btn-warning" style="padding: 10px 15px;"><i class="pi pi-pause" style="font-size: 40px;"></i></button>
        <a class="btn btn-outline-primary" @click="next()" icon="fas fa-angle-double-right" ><i class="pi pi-angle-double-right"></i></a>
      </div>
      <div class="col-3">
        <div class="player-time-total text-end" style="margin-top: 5px; font-size: 18px;">{{ convertTime(durationSeconds) }}</div>
      </div>
    </div>

    <div class="list-group" style="margin-top: 15px">
          <span v-for="(item, index) in files" class="list-group-item list-group-item-action" :class="{ active: item.id==file.id }" @click="changeTrack(item)">
            {{ item.title }}
          </span>
    </div>

  </div>
</template>


<script>
	import moment from 'moment'
	import lodash from 'lodash'

	export default {
		//name: 'PageItem',
		props: {
			files: {
				type: Array
			},
			item: {
				type: Object
			}
		},
		components: {
			//Dialog:Dialog,
		},
		data () {
			return {
				audio: undefined,
				file: {
					type: Object,
					default: null
				},
				currentSeconds: 0,
				durationSeconds: 0,
				playing:false,
				//file: null,
				loaded: false,
				//files: this.files,
				/*files:[
          {path:'audio/patrul-0.mp3', name:'Щенки спасают лес'},
					{path:'audio/patrul-1.mp3', name:'Щенки спасают театр'},
					{path:'audio/patrul-2.mp3', name:'Щенки спасают лес2'},
					{path:'audio/patrul-3.mp3', name:'Щенки спасают лес3'},
					{path:'audio/patrul-4.mp3', name:'Щенки спасают лес4'},
				],*/
			}
		},
		watch:{
		},
		mounted(){
		},
		created: function(){
			this.$nextTick(function() {
				this.initPlayer()
				this.audio = this.$refs.audio
				this.$refs.audio.addEventListener('timeupdate', this.update)
				this.$refs.audio.addEventListener('loadeddata', this.load)
				this.$refs.audio.addEventListener('pause', () => { this.playing = false; })
				this.$refs.audio.addEventListener('play', () => { this.playing = true; })
				this.$refs.audio.addEventListener('ended', () => { this.next(); this.playing = true; })
			})
		},
		//oncanplay
		//currentTime
		/*computed: {
			percentComplete() {
				return parseInt(this.currentSeconds / this.durationSeconds * 100);
			},
			muted() {
				return this.volume / 100 === 0;
			}
		},*/
		methods: {
			changeTrack(f){
				//this.file = f
        //console.log(f)

				if(f.path){
					this.file = f
					//this.durationSeconds = parseInt(this.$refs.audio.duration);
				}
				//this.$refs.audio.load()

				this.$nextTick(function() {
					  this.$refs.audio.load()
					  //if(this.playing === true) this.$refs.audio.play()
						//if(this.playing === true) this.$refs.audio.play()
						this.$refs.audio.play()
				})

			},
			load() {
				//console.log(this.$refs.audio.readyState)
				//if (this.$refs.audio.readyState >= 2) {
				this.loaded = true;
				console.log('loaded')
				//if(this.file === null){
				//this.file = this.files[0]
				this.durationSeconds = parseInt(this.$refs.audio.duration);
				//}
				//this.$refs.audio.load()
				//return this.playing = this.autoPlay;
				//}
				//throw new Error('Failed to load sound file.');
			},
			/*getSeconds(time){
				return moment.utc(time).format("SSS")
			},*/
			convertTime(time){
				let temp = moment.duration(time, 'seconds')
				return moment.utc(temp._milliseconds).format("HH:mm:ss")
			},
			update(e) {
				//console.log(this.$refs.audio.currentTime)
				//localStorage.setItem('currentTime', this.$refs.audio.currentTime)
				this.currentSeconds = parseInt(this.$refs.audio.currentTime)
				//this.currentSeconds = parseInt(localStorage.getItem('currentTime'))
				//current position
				//current teil
				//current book
			},
			seek(e) {
				/*if (!this.playing) {
					return;
				}*/
				//const el = e.target.getBoundingClientRect();
				//const seekPos = (e.clientX - el.left) / el.width;
				//this.$refs.audio.currentTime = parseInt(this.$refs.audio.duration * seekPos);
				console.log(e);
				this.$refs.audio.currentTime = e;
			},
			initPlayer: function(){
				if(!this.file.path){
					this.file = this.files[0]
					//this.durationSeconds = parseInt(this.$refs.audio.duration);
				}
				this.$refs.audio.load()
			},
			play: function () {
				//this.playing = true
				this.$refs.audio.play()

				//localStorage.setItem('item', 12345)
				//localStorage.item = JSON.stringify(this.item);
				//localStorage.files = this.files;

				/*this.$axios.post(this.globalConstants.apiUrl + 'countPlay', this.item, {withCredentials: true}).then((response) => {
					console.log(response)
				}).catch((e) => {
					console.log(e)
					//this.$q.notify({color: 'negative',position: 'top',message: 'Loading failed',icon: 'report_problem'})
				})*/
			},
			pause: function () {
				//this.playing = false
				this.$refs.audio.pause()
			},
			prev: function () {
				const current = _.indexOf(this.files, this.file)
				if(current>0){
					this.file = this.files[current-1]
				}else{
					this.file = this.files[0]
				}
				this.$nextTick(function() {
					this.$refs.audio.load()
					if(this.playing === true) this.$refs.audio.play()
				})
			},
			next: function () {
				const current = _.indexOf(this.files, this.file)
				if(this.files.length > current){
					this.file = this.files[current+1]
				}
				this.$nextTick(function() {
					this.$refs.audio.load()
					if(this.playing === true) this.$refs.audio.play()
				})
			},
		}
	}
</script>