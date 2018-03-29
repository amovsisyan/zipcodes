$(document).ready(function(){
    $('#country-select').material_select();
});
ZipCode = {
    allFieldsRequiredError: {
        error: true,
        type: '',
        response: ['Sorry all fields are required']
    },

    sendRequestBtn: document.getElementById('sendRequestBtn'),
    countrySelect: document.getElementById('country-select'),
    postCodeInput: document.getElementById('post-code'),
    resultContainer: document.getElementById('result-container'),

    // Places Additional
    postCodeAdd: document.getElementById('post-code-add'),
    countryNameAdd: document.getElementById('country-name-add'),
    countryAbbrAdd: document.getElementById('country-abbr-add'),

    // Places Parts
    placesInnerContainer: document.getElementsByClassName('places-inner-container')[0],
    placePart: document.getElementsByClassName('place-part')[0],

    _init: function () {
        this.generateListeners();
    },

    generateListeners: function () {
        var self = this;
        this.sendRequestBtn.addEventListener('click',
            self.getPlacesRequest.bind(self)
        );
    },

    getPlacesRequest: function () {
        var self = this,
            postCode = this.postCodeInput.value,
            countryID = this.countrySelect.options[this.countrySelect.selectedIndex].value,
            data = 'countryId=' + countryID + '&post_code=' + postCode,
            xhr = new XMLHttpRequest();

        updateAddConfirmButtons([this.sendRequestBtn], true);

        if (!countryID || !postCode) {
            handleResponseToast(this.allFieldsRequiredError, false);
            updateAddConfirmButtons([this.sendRequestBtn], false);
            return;
        }

        xhr.open('POST', location.pathname + 'getPlaces');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-CSRF-TOKEN', getCSRFToken());
        xhr.onload = function() {
            var response = JSON.parse(xhr.responseText);

            if (xhr.status === 200 && response.error !== true) {
                self._regeneratePlaces(response.response);
            } else if (xhr.status !== 200 || response.error === true) {
                self.resultContainer.classList.add('hide');
                handleResponseToast(response, false);
            }

            updateAddConfirmButtons([self.sendRequestBtn], false);
        };
        xhr.send(encodeURI(data));
    },

    _regeneratePlaces: function (response) {
        this._regeneratePlacesAdditional(response.additional);
        this._regeneratePlacesParts(response.places, response.additional);
        this.resultContainer.classList.remove('hide');
    },

    _regeneratePlacesAdditional: function (additional) {
        this.postCodeAdd.innerHTML = additional.postcode;
        this.countryNameAdd.innerHTML = additional.CountryName;
        this.countryAbbrAdd.innerHTML = additional.CountryAbbr;
    },

    _regeneratePlacesParts: function (places, additional) {
        var self = this;
        this.placesInnerContainer.innerHTML = '';
        Array.prototype.forEach.call(places, (function (place, index, array) {
            var clone = self.placePart.cloneNode(true);
            clone.getElementsByClassName('place-name')[0].innerHTML = place.placeName;
            clone.getElementsByClassName('place-long')[0].innerHTML = place.placeLong;
            clone.getElementsByClassName('place-lat')[0].innerHTML = place.placeLat;
            clone.getElementsByClassName('place-state-name')[0].innerHTML = additional.stateName;
            clone.getElementsByClassName('place-state-abbr')[0].innerHTML = additional.stateAbbr;
            self.placesInnerContainer.appendChild(clone);
        }));
    }
};

ZipCode._init();