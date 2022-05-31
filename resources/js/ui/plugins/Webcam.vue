<template>
	<div class="container-fluid">

		<!-- <section class="content">
			<div class="container-fluid">
				<div class="row">
				<div class="col-12">
					<p><span id="errorMsg"></span></p>
					<div class="video-wrap">
					<video id="video" playsinline autoplay></video>
					</div>
					<div class="controller">
					<button id="snap">Capture</button>
					</div>
					<canvas id="canvas" width="640" height="480"></canvas>
				</div>
				</div>
			</div>
		</section> -->
		<div class="row">
			<div class="col-12">
				<div class="upload-photo d-flex flex-row" style="flex:1">
					<img id="imageDisplay" :src="baseUrl + '/img/user.png'" alt="" >
				</div>
				<div class="upload-photo d-flex flex-row" style="flex:1">
					<p><span id="errorMsg"></span></p>
				</div>
				<div class="upload-photo d-flex flex-column" style="flex:1">
					<div class="video-wrap">
						<video hidden id="video" playsinline autoplay width="100%"></video>
					</div>
				</div>
				<div class="upload-photo d-flex flex-column" style="flex:1">
					<canvas hidden id="canvas" width="208.5" height="223.5"></canvas>
				</div>	
				
				<div class="upload-photo d-flex flex-column" style="flex:1">
					<a id="loadCamButton" href="#" class="btn btn-primary" v-on:click="loadCamera" style="padding:10px!important">Take a Photo</a>
				</div>	
				<div class="upload-photo d-flex flex-column" style="flex:1" >
					<a id="takePhotoButton" hidden href="#" class="btn btn-primary" v-on:click="takePhoto" style="padding:10px!important">Capture</a>
				</div>
				<div class="upload-photo d-flex flex-column" style="flex:1">
					<a href="#" class="btn btn-primary" style="padding:10px!important">Upload</a>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props:['token'],
	data(){
		return {
			baseUrl: window.location.origin
		}
	},
	methods:{
		showVid: function(stream){
			const video = document.getElementById('video');
			// const canvas = document.getElementById('canvas');
			const imgPrv = document.getElementById('imageDisplay');
			window.stream = stream;
			video.srcObject = stream;
			const camButton = document.getElementById('loadCamButton');
			const takeButton = document.getElementById('takePhotoButton');
			takeButton.removeAttribute("hidden");
			camButton.setAttribute("hidden",true);
			// canvas.removeAttribute("hidden");
			video.removeAttribute("hidden");
			imgPrv.setAttribute("hidden",true);

		},
		loadCamera:	 function(){
			'use strict';
			async function init(parent) {
				try {
					const stream = await navigator.mediaDevices.getUserMedia({
						audio: false,
						video: {
							width: 208.5,
							height: 223.5
						}
					});
					parent.showVid(stream);
				} catch (e) {
					document.querySelector('span#errorMsg').innerHTML = `navigator.getUserMedia error:${e.toString()}`;
				}
			}
			// Load init
			init(this);
		},
		takePhoto: function(){
			const video = document.getElementById('video');
			const canvas = document.getElementById('canvas');
			var context = canvas.getContext('2d');
			context.drawImage(video, 0, 0);
			video.setAttribute("hidden", true);
			// canvas.removeAttribute("hidden");
			var dataUrl = canvas.toDataURL();
			var imgPrv = document.getElementById('imageDisplay');
			imgPrv.removeAttribute("hidden");
			imgPrv = document.getElementById('imageDisplay');
			imgPrv.src = dataUrl;
		},
		loadCam2: function(){
			'use strict';
			const video = document.getElementById('video');
			const canvas = document.getElementById('canvas');
			const snap = document.getElementById("snap");
			const errorMsgElement = document.querySelector('span#errorMsg');
			const constraints = {
				audio: true,
				video: {
					width: 1280, height: 720
				}
			};
			// Access webcam
			async function init() {
				try {
					const stream = await navigator.mediaDevices.getUserMedia(constraints);
					handleSuccess(stream);
				} catch (e) {
					errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
				}
			}
			// Success
			function handleSuccess(stream) {
				window.stream = stream;
				video.srcObject = stream;
			}
			// Load init
			init();
			// Draw image
			var context = canvas.getContext('2d');
			snap.addEventListener("click", function() {
				context.drawImage(video, 0, 0, 640, 480);
			});
		}
	},
	mounted(){
		// this.loadCam2();
	}
}
</script>