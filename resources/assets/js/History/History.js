// const API_URL = 'http://127.0.0.1:8000/api/v1'; // http://infinite-journey-46117.herokuapp.com/api/v1';

require('eonasdan-bootstrap-datetimepicker');
require('../../../../node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css');

import template from './History.html';
import checkRequestStatus from './../helpers';

const OFFSET_SIZE = 20;

let offset = 0;
let loadedHistory = [];

function getHistory(settings) {
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
    const settings = {
      device_id: $('#js-history-device-selector').val(),
      start_date: $('#js-history-start-date').val(),
      end_date: $('#js-history-end-date').val()
    };
    loadNewHistoryData(settings);
  }
}

function loadNewHistoryData(settings) {
  return new Promise((resolve, reject) => {
    getHistory(settings).then(response => {
      if (response.isSuccess) {
        let data = convertData(response.data);
        concatLoadedHistory(data);
        renderHistory();
      }
    });
  });
}

function handleSearch(event) {
  event.preventDefault();
  const settings = {
    device_id: $('#js-history-device-selector').val(),
    start_date: $('#js-history-start-date').val(),
    end_date: $('#js-history-end-date').val(),
    keyword: $('#js-history-keyword').val()
  };
  offset = 0;
  loadedHistory = [];
  loadNewHistoryData(settings);
}

function handleReset() {
  offset = 0;
  loadedHistory = [];
  loadNewHistoryData();
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

  $(document)
    .on('submit', '#js-history-form', handleSearch)
    .on('reset', '#js-history-form', handleReset);

  $(window).on('scroll', _.throttle(detectScroll, 100));

  $('.input-daterange input').each(function() {
    $(this).datepicker({
      clearDates: true,
      format: 'YYYY-MM-DD HH:mm:ss'
    });
  });

  loadNewHistoryData();
});
