import axios from "axios";

// disable select suite and establishment
const selectEstablishment = document.getElementById('booking_establishment');
const selectSuite = document.getElementById('booking_suite');

selectEstablishment.setAttribute('disabled', '');
selectSuite.setAttribute('disabled', '');

// pre fill select suite
if (document.body.addEventListener){
    document.body.addEventListener('click',yourHandler,false);
}

function yourHandler(e){
    let target = e.target;
    if (target.className.match('.btn-booking'))
    {
        const $select = document.querySelector('#booking_suite');
        $select.value =  e.target.dataset.id;
    }
}

// check availability suite
window.addEventListener("load", function() {
    document.querySelector("button.js-suites").addEventListener("click", getAvailabilitySuite);
    document.querySelector("button.js-suites-close").addEventListener("click", quitBooking);
});

function getAvailabilitySuite (event) {
    event.preventDefault();
    let url = "/suite";
    quitBooking(event);

// ajax call with axios in route /suite
    axios.get(url).then(response => {
        const divAvailability = document.querySelector("div.response-availability");
        const idSuite = parseInt(document.querySelector("#booking_suite").value);
        let statusAvailability = 0;

        response.data.forEach(({availability, id}) => {
            if(id === idSuite){
                const nodeStatus = document.createElement("div");
                const nodeLink = document.createElement("a");
                if (availability === true) {
                    statusAvailability = 1;
                    nodeStatus.classList.add("text-success");
                    nodeStatus.classList.add("ajax");
                    nodeStatus.classList.add("ml-3");
                    nodeStatus.textContent = "This Suite is available";

                    let statusAuth = authStatus();
                    if(statusAuth === 'isLogged') {
                        nodeLink.textContent = "Confirm your reservation"
                        nodeLink.href = "/dashboard";
                    } else {
                        nodeLink.textContent = "register you to validate your reservation: register";
                        nodeLink.href = "/register";
                    }

                    divAvailability.appendChild(nodeStatus);
                    divAvailability.appendChild(nodeLink);
                    setCookie(1, statusAvailability);
                } else {
                    nodeStatus.classList.add("text-danger");
                    nodeStatus.classList.add("ajax");
                    nodeStatus.textContent = 'This suite is unavailable. check other suite';
                }
                divAvailability.appendChild(nodeStatus);
            }
        });
    });
}

// if booking cancel, remove availability notification
function quitBooking (event) {
    event.preventDefault();
    if(document.querySelector("div.ajax")) {
        const check = document.querySelector("div.response-availability");

        while (check.hasChildNodes()) {
            check.removeChild(check.firstChild);
        }
    }
}

// get status authentification
function authStatus () {
    let paramAuth = document.getElementById("status_auth");
    let statusAuth = 'notLogged';

    if(paramAuth) {
        statusAuth = paramAuth.value;
    }

    return statusAuth;
}

// create cookie with booking values
function setCookie(exDays, statusAvailability) {
    const d = new Date();
    d.setTime(d.getTime() + (exDays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();

    let cName = "dataBooking";
    let cValue = new Array(5);

    let dateStart = document.querySelector("#booking_date_debut_year").value + "/" +
        document.querySelector("#booking_date_debut_month").value + "/" +
        document.querySelector("#booking_date_debut_day").value;

    let dateEnd = document.querySelector("#booking_date_fin_year").value + "/" +
    document.querySelector("#booking_date_fin_month").value + "/" +
    document.querySelector("#booking_date_fin_day").value;

    cValue[0] = document.querySelector("#booking_establishment").value;
    cValue[1] = document.querySelector("#booking_suite").value;
    cValue[2] = dateStart;
    cValue[3] = dateEnd;
    cValue[4] = statusAvailability;

    document.cookie = cName + "=" + cValue + ";" + expires + ";path=/";
}
