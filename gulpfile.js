const { src, dest, series } = require('gulp')
const zip = require('gulp-zip')
const filter = require('gulp-filter')

const sourceMapsFilter = filter(['**', '!**/*.map'])
const plugin = require('./plugin.config.json')

const replace = require('gulp-replace')
const clean = require('gulp-clean')

const fileName = plugin.slug

const config = {
  zipName: fileName + '.' + plugin.version + '.zip',
  mlNamespace: 'M' + plugin.namespace,
  sourceFolder: 'src',
  distFolder: 'dist',
  tempFolder: 'dist-temp',
}

function create(cb) {
  src(config.sourceFolder + '/**')
    .pipe(sourceMapsFilter)
    .pipe(replace('Masteryl', config.mlNamespace))
    .pipe(dest(config.tempFolder + '/' + fileName))
    .on('finish', cb)
}

// Remove tests and lib/Test dirs.
function removeTestsLib(cb) {
  const plugin = config.tempFolder + '/' + fileName
  src(plugin + '/lib/Test', { read: false })
    .pipe(clean())
    .on('finish', cb)
}
function removeTests(cb) {
  const plugin = config.tempFolder + '/' + fileName
  src(plugin + '/tests', { read: false })
    .pipe(clean())
    .on('finish', () => removeTestsLib(cb))
}
function removeDev(cb) {
  const plugin = config.tempFolder + '/' + fileName
  src(plugin + '/dev', { read: false })
    .pipe(clean())
    .on('finish', cb)
}

// function removeLibTests(cb) {
//   src(config.tempPlugin + '/lib/Test', { read: false })
//     .pipe(clean())
//     .on('finish', cb)
// }

function zipTemp(cb) {
  src(config.tempFolder + '/**')
    .pipe(zip(config.zipName))
    .pipe(dest(config.distFolder))
    .on('finish', cb)
}

function removeTemp(cb) {
  src(config.tempFolder, { read: false }).pipe(clean()).on('finish', cb)
}

function removePlugin(cb) {
  const file = config.distFolder + '/' + config.zipName
  src(file, { read: false }).pipe(clean()).on('finish', cb)
}

exports.removePlugin = removePlugin
exports.removeTemp = removeTemp
exports.create = create
exports.removeTests = removeTests

exports.buildWithTests = series(create, zipTemp, removeTemp)
exports.default = series(create, removeTests, removeDev, zipTemp, removeTemp)
