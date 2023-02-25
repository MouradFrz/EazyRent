import "bootstrap";
import flatpickr from "flatpickr";
require("flatpickr/dist/themes/airbnb.css");
flatpickr("#mydate", {
  enableTime: true,
  time_24hr: true,
  minDate: new Date().fp_incr(1),
  maxDate: new Date().fp_incr(30),
  mode: "range",
  theme: "airbnb",
});
