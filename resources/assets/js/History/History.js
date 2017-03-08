// const API_URL = 'http://127.0.0.1:8000/api/v1'; // http://infinite-journey-46117.herokuapp.com/api/v1';

require('eonasdan-bootstrap-datetimepicker');
require('../../../../node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css');

// require('bootstrap-datepicker');
// require('../../../../node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css');

import template from './History.html';
import checkRequestStatus from './../helpers';

const OFFSET_SIZE = 20;

let offset = 0;
let isLoading = false;
const loadedHistory = [];

function getHistory(settings) {
  settings = {
    // device_id: 3
    // start_date: '2017-03-05 02:58:55',
    // end_date: '2017-03-05 02:59:55'
  };

  return new Promise((resolve, reject) => {
    const searchQuery = settings ? $.param(settings) : '';
    fetch(`/json/history?offset=${ offset }&` + searchQuery, {
      method: 'GET',
      credentials: 'include'
    })
      .then(checkRequestStatus)
      .then(resolve)
      .catch(error => {
        reject(error.response);
      });
    offset = offset + OFFSET_SIZE;
  });
}

function convertData(data) {
  let dataArray = Object.keys(data.visits).map(key => {
    return {
      groupName: key,
      visits: data.visits[key]
    }
  });

  dataArray.forEach(item => {
    item.visits.map(visit => {
      return visit.shortDate = moment(visit.created_at, 'YYYY-MM-DD HH:mm:ss').format('LT')
    });
  });
  // dataArray = dataArray.map(item => {
  //   return {
  //     visits: item
  //   };
  // });
  return dataArray;
}

function concatLoadedHistory(data) {
  data.forEach(group => {
    const loadedGroup = loadedHistory.find(loadedGroup => loadedGroup.groupName === group.groupName);
    if (loadedGroup) {
      loadedGroup.visits = loadedGroup.visits.concat(group.visits);
    } else {
      loadedHistory.push(group);
    }
  });
}

function renderHistory() {
  console.log(loadedHistory);
  const $template = $(Mustache.render(template, {
    visitGroups: loadedHistory
  }));
  $('#js-history').html($template);
}

function detectScroll(event) {
  if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
    loadNewHistoryData();
  }
}

function loadNewHistoryData() {
  getHistory().then(response => {
    if (response.isSuccess) {
      let data = convertData(response.data);
      concatLoadedHistory(data);
      renderHistory();
    }
  });
}

$(() => {
  const $startDate = $('#js-history-start-date');
  const $endDate = $('#js-history-end-date');
  $startDate.datetimepicker();
  $endDate.datetimepicker({
    useCurrent: false
  });
  $startDate.on('dp.change', function (e) {
    $endDate.data('DateTimePicker').minDate(e.date);
  });
  $endDate.on("dp.change", function (e) {
    $startDate.data('DateTimePicker').maxDate(e.date);
  });

  $(document).on('submit', '#js-history-form', event => {
    event.preventDefault();
    loadNewHistoryData();
  });

  $(window).on('scroll', _.throttle(detectScroll, 100));

  $('.input-daterange input').each(function() {
    $(this).datepicker({
      clearDates: true,
      format: 'YYYY-MM-DD HH:mm:ss'
    });
  });

  loadNewHistoryData();
});
