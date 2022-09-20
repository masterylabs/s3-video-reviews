/** @format */

export const mins = [
  '00',
  '01',
  '02',
  '03',
  '04',
  '05',
  '06',
  '07',
  '08',
  '09',
  '10',
  '11',
  '12',
  '13',
  '14',
  '15',
  '16',
  '17',
  '18',
  '19',
  '20',
  '21',
  '22',
  '23',
  '24',
  '25',
  '26',
  '27',
  '28',
  '29',
  '30',
  '31',
  '32',
  '33',
  '34',
  '35',
  '36',
  '37',
  '38',
  '39',
  '40',
  '41',
  '42',
  '43',
  '44',
  '45',
  '46',
  '47',
  '48',
  '49',
  '50',
  '51',
  '52',
  '53',
  '54',
  '55',
  '56',
  '57',
  '58',
  '59',
]

export const hours = [
  '00',
  '01',
  '02',
  '03',
  '04',
  '05',
  '06',
  '07',
  '08',
  '09',
  '10',
  '11',
  '12',
  '13',
  '14',
  '15',
  '16',
  '17',
  '18',
  '19',
  '20',
  '21',
  '22',
  '23',
]

export const hours12 = [
  '1',
  '2',
  '3',
  '4',
  '5',
  '6',
  '7',
  '8',
  '9',
  '10',
  '11',
  '12',
]

// v1.0.3
export const displayTime = (secs) => {
  secs = parseInt(secs)
  var minutes = Math.floor(secs / 60)
  secs = secs % 60
  var hours = Math.floor(minutes / 60)
  minutes = minutes % 60

  if (secs > 3600) {
    return (
      hours + ':' + ('0' + minutes).slice(-2) + ':' + ('0' + secs).slice(-2)
    )
  }
  return ('0' + minutes).slice(-2) + ':' + ('0' + secs).slice(-2)
}

export const getTenths = (secs) => {
  let hunds = secs - Math.floor(secs)
  return Math.round(hunds * 10)
}

export const prettyTime = (secs, hundreds = false, tenths = false) => {
  var hunds = 0

  if (hundreds) {
    hunds = secs - Math.floor(secs)

    if (tenths) {
      hunds = Math.round(hunds * 10)
    } else {
      hunds = Math.floor(hunds * 100)
    }
  }

  secs = Math.floor(secs)

  var hrs = 0,
    mins = 0 //, t = secs;

  if (secs >= 3600) {
    hrs = Math.floor(secs / 3600)
    secs = secs - hrs * 3600
  }

  if (secs >= 60) {
    mins = Math.floor(secs / 60)
    secs = secs - mins * 60
  }

  var display = ''

  if (hrs > 0) {
    // if (hrs < 10) {
    //   display += "0";
    // }
    display += hrs + ':'
  }

  if (mins < 10) {
    mins = '0' + mins
  }
  display += mins + ':'

  if (secs < 0) {
    secs = 0
  }

  if (secs < 10) {
    secs = '0' + secs
  }

  if (hundreds) {
    if (tenths) {
      secs += ':' + hunds
    } else {
      if (hunds < 10) {
        hunds = '0' + hunds
      }
      secs += ':' + hunds
    }
  }

  return display + secs
}

export const getFromHMS = (hms) => {
  var secs = 0,
    mins = 0,
    hrs = 0

  if (!isNaN(hms.s)) {
    secs = parseInt(hms.s)
  }
  if (!isNaN(hms.m)) {
    mins = parseInt(hms.m)
  }
  if (!isNaN(hms.h)) {
    hrs = parseInt(hms.h)
  }

  //  var secs = parseInt(hms.s), mins = parseInt(hms.m), hrs = parseInt(hms.h)

  if (hrs > 0) {
    secs = secs + hrs * 3600
  }
  if (mins > 0) {
    secs = secs + mins * 60
  }
  return secs
}

// hundreths seconds / micro time: 10-100
export const getTime = (t, mt = 0, doubleDigits = false) => {
  t = parseInt(t)

  let days = 0,
    hrs = 0,
    mins = 0,
    secs = 0,
    hs = 0

  if (mt && mt > 0) {
    secs = Math.floor(t / mt)
    mt = t - secs * mt
  } else {
    secs = t
  }

  if (secs >= 86400) {
    days = Math.floor(secs / 86400)
    secs = secs - days * 86400
  }

  if (secs >= 3600) {
    hrs = Math.floor(secs / 3600)
    secs = secs - hrs * 3600
  }

  if (secs >= 60) {
    mins = Math.floor(secs / 60)
    secs = secs - mins * 60
  }

  if (doubleDigits) {
    if (hrs < 10) {
      // hrs = '0'+hrs
    }
    if (mins < 10) {
      mins = '0' + mins
    }
    if (secs < 10) {
      secs = '0' + secs
    }
  }

  return {
    d: days,
    h: hrs,
    m: mins,
    s: secs,
    mt: mt,
    t: t, // total seconds
  }
}

export const getHMS = (secs, doubleDigits = true) => {
  var hrs = 0,
    mins = 0,
    t = parseInt(secs)

  if (secs >= 3600) {
    hrs = Math.floor(secs / 3600)
    secs = secs - hrs * 3600
  }

  if (secs >= 60) {
    mins = Math.floor(secs / 60)
    secs = secs - mins * 60
  }

  if (doubleDigits) {
    if (hrs < 10) {
      // hrs = '0'+hrs
    }
    if (mins < 10) {
      mins = '0' + mins
    }
    if (secs < 10) {
      secs = '0' + secs
    }
  }

  return {
    h: hrs,
    m: mins,
    s: secs,
    t: t, // total seconds
  }
}

export const getHMSDisplay = (secs, doubleDigits = true) => {
  if (!secs || isNaN(secs)) {
    if (doubleDigits) {
      return '00:00'
    }
    return '0:00'
  }

  var hrs = 0,
    mins = 0,
    t = parseInt(secs)
  var display = ''

  if (secs >= 3600) {
    hrs = Math.floor(secs / 3600)
    secs = secs - hrs * 3600
  }

  if (secs >= 60) {
    mins = Math.floor(secs / 60)
    secs = secs - mins * 60
  }

  if (doubleDigits) {
    if (hrs < 10) {
      // hrs = '0'+hrs
    }
    if (mins < 10) {
      mins = '0' + mins
    }
    if (secs < 10) {
      secs = '0' + secs
    }
  }

  if (hrs > 0) {
    display += hrs + ':'
  }

  display += mins + ':' + secs

  return display
}
