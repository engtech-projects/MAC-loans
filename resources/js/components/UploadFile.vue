<template>
	<div class="modal" id="uploadModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg minw-45" role="document">
			<div class="modal-content">
				<div class="modal-body p-24">
					<div class="container">
						<h2>Current Camera</h2>
						<code v-if="device">{{ device.label }}</code>
						<web-cam ref="webcam"
								:device-id="deviceId"
								width="100%"
								@started="onStarted" 
								@stopped="onStopped" 
								@error="onError"
								@cameras="onCameras"
								@camera-change="onCameraChange"
								style="background-color:#000"
								class="mb-16" />
							<div class="d-flex">
								<select v-model="camera" class="form-control flex-1 mr-16">
								<option>-- Select Device --</option>
								<option v-for="device in devices" 
										:key="device.deviceId" 
										:value="device.deviceId">{{ device.label }}</option>
								</select>
								<input id="selectImage" type="file" accept="image/*" class="hide" @change="encodeImageFileAsURL()">
								<button type="button" 
										class="btn btn-success mr-10" 
										@click="selectImage()">Upload File</button>
								<button type="button" 
										class="btn btn-primary mr-10" 
										@click="onCapture">Capture Photo</button>
								<button type="button" 
										class="btn btn-danger" 
										data-dismiss="modal"
										>Close</button>
							</div>
							
							<!-- <button type="button" 
									class="btn btn-success" 
									@click="onStart">Start Camera</button> -->
						<!-- <h2>Captured Image</h2>
						<figure class="figure">
						<img :src="img" class="img-responsive" >
						</figure> -->
					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { WebCam } from "vue-web-cam";
import { find, head } from "lodash";

export default {
  name: "UploadFile",
  components: {
    WebCam
  },
  data() {
    return {
      img: null,
      camera: null,
      deviceId: null,
      devices: [],
    };
  },
  computed: {
    device() {
      return find(this.devices, n => n.deviceId == this.deviceId);
    }
  },
   watch: {
    camera: function(id) {
      this.deviceId = id;
    },
    devices: function() {
      // Once we have a list select the first one
      let first = head(this.devices);
      if (first) {
        this.camera = first.deviceId;
        this.deviceId = first.deviceId;
      }
    }
  },
  methods: {
    onCapture() {
      this.img = this.$refs.webcam.capture();
	  this.$emit('imageCapture', this.img);
    },
    onStarted(stream) {
    //   console.log("On Started Event", stream);
    },
    onStopped(stream) {
    //   console.log("On Stopped Event", stream);
    },
    onStop() {
      this.$refs.webcam.stop();
    },
    onStart() {
      this.$refs.webcam.start();
    },
    onError(error) {
    //   console.log("On Error Event", error);
    },
    onCameras(cameras) {
      this.devices = cameras;
    //   console.log("On Cameras Event", cameras);
    },
    onCameraChange(deviceId) {
      this.deviceId = deviceId;
      this.camera = deviceId;
    //   console.log("On Camera Change Event", deviceId);
    },
	selectImage:function(){
		var input = document.getElementById('selectImage');
		input.click();
	},
	encodeImageFileAsURL:function() {
		var file = document.getElementById('selectImage').files[0];
		var reader = new FileReader();
		reader.onloadend = function() {
			this.img = reader.result;
			this.$emit('imageCapture', this.img);
		}.bind(this);
		reader.readAsDataURL(file);
	}
  }
};
</script>
<style scoped>
	h3 {
	margin: 40px 0 0;
	}
	ul {
	list-style-type: none;
	padding: 0;
	}
	li {
	display: inline-block;
	margin: 0 10px;
	}
	a {
	color: #42b983;
	}
</style>
