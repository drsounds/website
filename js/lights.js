// Lights from https://www.flickr.com/photos/ganboo3000/3293380311/in/photolist-622rea-qsr7gn-5yzG1F-dCmmkf-5CRCKe-5RNFsS-bw337K-5JdsSp-5FxYK8-4em7MQ-4sq8xn-5FCgEd-74UPni-5Lekp7-cgk2u-9gsXg-efGzT8-ayVsSS-ehgLYg-49PeDC-5Fc7cK-4r3REQ-5HFFP7-5LejwC-8Tgk4r-9fL2BC-DfjsZR-2ux7Gh-aZGw2z-55qYqf-q9xHav-7DRJka-5FWea1-bsfxHT-4Ae68N-fngAct-6DL4WN-brNUJm-7yQJcE-7srwTZ-4YHrr8-b6WgFK-6buCxX-Caf4M-qt9eFP-4uFsHD-nBeNsF-bkFs1d-bohsS5-58fL8t


var LightsElementProto = Object.create(HTMLElement.prototype);

LightsElementProto.createdCallback = function () {
	this.numberOfLights = 100;
	var self = this;
	setInterval(function () {
		self.addRandomLight();
		var lights = self.querySelectorAll('sp-light');
		for (var l in lights) {
			var light = lights[l];
			if (light.style) {
				light.style.left = parseInt(light.style.left) - 25 + 'px';
				if (light.style.opacity == 0) {
					self.removeChild(light);
				}
			}
		}
	}, 100);

}

LightsElementProto.addRandomLight = function () {
	var light = new LightElement();
	light.style.position = 'absolute';
	light.style.left = Math.random() * window.innerWidth + 'px';
	light.style.top = Math.random() * window.innerHeight + 'px';

	this.appendChild(light);
}

LightsElementProto.attributeChangedCallback = function (attrName, newValue, oldVal) {

}

window.LightsElement = document.registerElement('sp-lights', {
	prototype: LightsElementProto
});


var LightElementProto = Object.create(HTMLElement.prototype);
LightElementProto.createdCallback = function () {
	this.innerHTML = '<img src="img/light.png" width="620pt">';
	this.img = this.querySelector('img');
	this.img.style.mixBlendMode = 'lighten';
	this.style.opacity = Math.random() * 1;

	var self = this;
	setTimeout(function () {
		self.style.opacity = 0;

	}, Math.random() * 3000);this.img.style.webkitFilter = 'hue-rotate(' + Math.random () * 360 + 'deg)';
}

LightElementProto.attributeChangedCallback = function (attrName, newVal, oldVal) {
	if (attrName == 'hue') {
		this.img.style.webkitFilter = 'hue-rotate(' + newVal + 'deg)';
	}
	if (attrName == 'opacity') {
		this.style.opacity = parseFloat(newVal);
		if (parseFLoat(newVal) == 0) {
			this.parentNode.removeChild(this);
		}
	}
	if (attrName == 'duration') {
		this.style.opacity = 1;
	}
}

window.LightElement = document.registerElement('sp-light', {
	prototype: LightElementProto
});