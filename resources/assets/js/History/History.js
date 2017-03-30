// const API_URL = 'http://127.0.0.1:8000/api/v1'; // http://infinite-journey-46117.herokuapp.com/api/v1';
$ = window.$;

import enquire from 'enquire.js';

import template from './History.html';
import checkRequestStatus from './../helpers';

const OFFSET_SIZE = 20;

let offset = 0;
let loadedHistory = [];
let selectedHistory = [];
let isLoading = false;

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

function removeItemsFromLoadedHistory(ids) {
  loadedHistory.forEach(loadedGroup => {
    _.remove(loadedGroup.visits, visit => {
      return ids.indexOf(String(visit.id)) !== -1;
    });
  });
}

function renderHistory() {
  const $template = $(Mustache.render(template, {
    visitGroups: loadedHistory
  }));
  $('#js-history').html($template);
  selectedHistory.forEach(item => {
    $(`.js-history-remove-checkbox[value=${ item }]`).prop('checked', true);
  });
}

function detectScroll(event) {
  if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight && !isLoading) {
    selectedHistory = [];
    $('.js-history-remove-checkbox:checked').each(function() {
      const id = $(this).val();
      selectedHistory.push(id);
    });

    const settings = {
      device_id: $('#js-history-device-selector').val(),
      start_date: $('#js-history-start-date').val(),
      end_date: $('#js-history-end-date').val()
    };
    loadNewHistoryData(settings);
  }
}

function setAds() {
  let isFirstAdSet = false;
  let isSecondtAdSet = false;
  let isThirdAdSet = false;
  let totalIterator = 0;

  for (let historyGroup of loadedHistory) {
    if (isThirdAdSet) {
      break;
    }

    for (let visit of historyGroup.visits) {
      if (isThirdAdSet) {
        break;
      }
      totalIterator = totalIterator + 1;
      if (totalIterator === 3) {
        visit.showAds = true;
        isFirstAdSet = true;
      } else if (totalIterator === 10) {
        visit.showAds = true;
        isSecondtAdSet = true;
      } else if (totalIterator === 20) {
        visit.showAds = true;
        isThirdAdSet = true;
      }
    }
  }

  loadedHistory.forEach(historyGroup => {
    historyGroup.visits.forEach();
  });

  if (loadedHistory.length && loadedHistory[0] && loadedHistory[0].visits) {
    if (loadedHistory[0].visits.length >= 3) {
      loadedHistory[0].visits[2].showAds = true;
    } else {
      if (loadedHistory[0].visits[0]) {
        loadedHistory[0].visits[0].showAds = true;
      }
    }
  }
}

function loadNewHistoryData(settings) {
  return new Promise((resolve, reject) => {
    getHistory(settings).then(response => {
      if (response.isSuccess) {
        let data = convertData(response.data);
        concatLoadedHistory(data);
        console.log(loadedHistory);
        setAds();
        renderHistory();
        (adsbygoogle = window.adsbygoogle || []).push({});
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
  selectedHistory = [];
  loadNewHistoryData(settings);
}

function handleReset() {
  offset = 0;
  loadedHistory = [];
  selectedHistory = [];
  $('.js-history-group-checkbox').prop('checked', false);
  $('.js-history-remove-checkbox').prop('checked', false);
  loadNewHistoryData();
}

function removeHistory(data) {
  return new Promise((resolve, reject) => {
    isLoading = true;
    fetch(`/json/history`, {
      method: 'DELETE',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        data
      })
    })
      .then(checkRequestStatus)
      .then(response => {
        isLoading = false;
        resolve(response);
      })
      .catch(error => {
        isLoading = false;
        reject(error.response);
      });
  });
}

function selectGroup(event) {
  const $groupCheckbox = $(event.target);
  const $checkboxes = $groupCheckbox.closest('.js-history-group').find('.js-history-remove-checkbox');
  const isChecked = $groupCheckbox.is(':checked');
  $checkboxes.prop('checked', isChecked);
  // $checkboxes.each(function() {
  //   const $checkbox = $(this);
  //   $checkbox.prop('checked', isChecked);
  // });
}

function selectHistoryCheckbox(event) {
  const $checkbox = $(event.target);
  const $group = $checkbox.closest('.js-history-group');
  const $checkboxes = $group.find('.js-history-remove-checkbox');
  const $selectedCheckboxes = $checkboxes.filter(':checked');
  $group.find('.js-history-group-checkbox').prop('checked', $checkboxes.length === $selectedCheckboxes.length);
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
  $endDate.on('dp.change', function (e) {
    $startDate.data('DateTimePicker').maxDate(e.date);
  });

  $(document)
    .on('submit', '#js-history-form', handleSearch)
    .on('reset', '#js-history-form', handleReset)
    .on('click', '.js-history-group-checkbox', selectGroup)
    .on('change', '.js-history-remove-checkbox', selectHistoryCheckbox)
    .on('click', '#js-history-remove-all-button', function () {
      $('#js-history-confirmation-modal').modal('show');
    })
    .on('click', '#js-history-all-remove-proceed', () => removeHistory({
      type: 'all'
    }).then(response => {
      if (response.isSuccess) {
        $('#js-history-confirmation-modal').modal('hide');
        $('#js-history').empty();
      }
    }))
    .on('click', '#js-history-remove-selected-button', function (event) {
      event.preventDefault();
      const ids = [];
      const $checkedRows = $('.js-history-remove-checkbox:checked');
      $checkedRows.each(function() {
        const id = $(this).val();
        ids.push(id);
      });
      if (!ids.length) {
        return;
      }
      removeHistory({
        ids: ids,
        type: 'partial'
      }).then(response => {
        if (response.isSuccess) {
          removeItemsFromLoadedHistory(ids);
          $checkedRows.closest('.js-history-row').remove();
          $('.js-history-group').filter(function() {
            return !$(this).find('.js-history-row').length;
          }).remove();
        }
      });
    });

  $(window).on('scroll', _.debounce(detectScroll, 500));

  $('.input-daterange input').each(function() {
    $(this).datepicker({
      clearDates: true,
      format: 'YYYY-MM-DD HH:mm:ss'
    });
  });

  loadNewHistoryData();


    enquire.register('(max-width:992px)', function() {
       $('#js-history-form-container').removeClass('in');
       $('#js-history-form-toggler').removeClass('hidden');
    });
});
