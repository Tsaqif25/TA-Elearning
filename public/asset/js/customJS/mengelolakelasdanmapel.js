// ==========================================
// FILE: public/js/teacher-subjects.js
// FUNGSI: Mengelola kelas dan mapel untuk pengajar
// ==========================================

// ==========================================
// VARIABEL GLOBAL
// ==========================================
let config = window.teacherConfig || {};
let rowData = [];
let rowIndex = 0;

// ==========================================
// FUNGSI UTAMA - DIJALANKAN SAAT HALAMAN SIAP
// ==========================================
$(document).ready(function() {
    console.log('Teacher Subjects Manager loaded');
    
    // Load data yang sudah ada
    loadExistingData();
    
    // Setup event listeners
    setupEventListeners();
});

// ==========================================
// LOAD DATA YANG SUDAH ADA DARI DATABASE
// ==========================================
function loadExistingData() {
    console.log('Loading existing data:', config.existingData);
    
    if (config.existingData && config.existingData.length > 0) {
        config.existingData.forEach(function(data) {
            addRowToTable(data.kelasName, data.mapelName, false);
            
            rowData.push({
                kelas: data.kelasId,
                mapel: data.mapelId
            });
            
            rowIndex++;
        });
        
        console.log('Loaded ' + config.existingData.length + ' existing records');
    }
}

// ==========================================
// SETUP EVENT LISTENERS
// ==========================================
function setupEventListeners() {
    
    // 1. KETIKA KELAS DIPILIH
    $('#kelas').on('change', function() {
        handleKelasChange();
    });

    // 2. KETIKA TOMBOL TAMBAH DIKLIK
    $('#btnTambah').on('click', function() {
        tambahKelasMapel();
    });

    // 3. KETIKA TOMBOL DELETE DIKLIK (Event Delegation)
    $('#tabelKelas').on('click', '.delete-btn', function() {
        handleDeleteRow($(this));
    });
    
    console.log('Event listeners setup complete');
}

// ==========================================
// HANDLE PERUBAHAN KELAS
// ==========================================
function handleKelasChange() {
    let kelasId = $('#kelas').val();
    
    if (kelasId !== 'kosong') {
        console.log('Kelas selected:', kelasId);
        loadMapelByKelas(kelasId);
    } else {
        resetMapelSelect();
    }
}

// ==========================================
// LOAD MAPEL BERDASARKAN KELAS
// ==========================================
function loadMapelByKelas(kelasId) {
    // Show loading dan disable controls
    showLoading(true);
    setMapelDisabled(true);
    setTambahDisabled(true);

    // AJAX call untuk get mapel
    $.ajax({
        url: config.urls.searchKelasMapel,
        method: 'GET',
        data: { kelasId: kelasId },
        success: function(dataMapel) {
            console.log('Mapel data loaded:', dataMapel);
            populateMapelOptions(dataMapel);
            
            // Enable controls
            setMapelDisabled(false);
            setTambahDisabled(false);
        },
        error: function(xhr, status, error) {
            console.error('Error loading mapel:', error);
            showAlert('Gagal memuat data mapel: ' + error);
            
            setMapelDisabled(true);
            setTambahDisabled(true);
        },
        complete: function() {
            showLoading(false);
        }
    });
}

// ==========================================
// POPULATE MAPEL SELECT OPTIONS
// ==========================================
function populateMapelOptions(dataMapel) {
    let mapelSelect = $('#mapel');
    
    // Clear existing options
    mapelSelect.empty().append('<option value="" selected>Pilih Mapel</option>');

    // Add mapel options
    $.each(dataMapel, function(index, mapel) {
        let optionText = mapel.name;
        let option = $('<option></option>').attr('value', mapel.id).text(optionText);
        
        if (mapel.exist) {
            option.prop('disabled', true);
            option.text(optionText + ' (Sudah ada pengajar)');
        }
        
        mapelSelect.append(option);
    });
}

// ==========================================
// FUNGSI TAMBAH KELAS & MAPEL
// ==========================================
function tambahKelasMapel() {
    let kelasId = $('#kelas').val();
    let mapelId = $('#mapel').val();
    
    console.log('Adding kelas:', kelasId, 'mapel:', mapelId);
    
    // 1. VALIDASI INPUT
    if (!validateInput(kelasId, mapelId)) {
        return;
    }

    // 2. CEK DUPLIKAT
    if (isDuplicate(kelasId, mapelId)) {
        showAlert('Kelas dan Mapel sudah ada dalam daftar.');
        return;
    }

    // 3. CEK KE DATABASE
    checkMapelAvailability(kelasId, mapelId);
}

// ==========================================
// VALIDASI INPUT
// ==========================================
function validateInput(kelasId, mapelId) {
    if (kelasId === 'kosong') {
        showAlert('Silahkan pilih kelas terlebih dahulu!');
        return false;
    }
    
    if (!mapelId) {
        showAlert('Silahkan pilih mapel terlebih dahulu!');
        return false;
    }
    
    return true;
}

// ==========================================
// CEK DUPLIKAT
// ==========================================
function isDuplicate(kelasId, mapelId) {
    return rowData.some(function(row) {
        return row.kelas === kelasId && row.mapel === mapelId;
    });
}

// ==========================================
// CEK KETERSEDIAAN MAPEL DI DATABASE
// ==========================================
function checkMapelAvailability(kelasId, mapelId) {
    $.ajax({
        url: config.urls.cekKelasMapel,
        method: 'GET',
        data: {
            kelasId: kelasId,
            mapelId: mapelId,
        },
        success: function(response) {
            if (response.response == 1) {
                showAlert('Mapel sudah memiliki pengajar');
                return;
            }
            
            // Jika available, tambah ke tabel dan database
            processAddMapel(kelasId, mapelId);
        },
        error: function(xhr, status, error) {
            console.error('Error checking mapel:', error);
            showAlert('Error: ' + error);
        }
    });
}

// ==========================================
// PROSES TAMBAH MAPEL
// ==========================================
function processAddMapel(kelasId, mapelId) {
    let kelasName = $('#kelas option:selected').text();
    let mapelName = $('#mapel option:selected').text();

    // 1. Tambah ke tabel
    addRowToTable(kelasName, mapelName, true);

    // 2. Simpan ke array
    rowData.push({
        kelas: kelasId,
        mapel: mapelId,
    });
    rowIndex++;

    // 3. Simpan ke database
    saveEditorAccess(kelasId, mapelId);

    // 4. Reset form
    resetForm();
    
    console.log('Mapel added successfully');
}

// ==========================================
// TAMBAH ROW KE TABEL
// ==========================================
function addRowToTable(kelasName, mapelName, showDeleteButton = true) {
    let deleteButton = '';
    if (showDeleteButton) {
        deleteButton = '<button type="button" class="btn btn-danger btn-sm delete-btn">' +
                      '<i class="fa-solid fa-trash"></i> Delete</button>';
    }

    let newRow = '<tr>' +
        '<td>' + kelasName + '</td>' +
        '<td>' + mapelName + '</td>' +
        '<td>' + deleteButton + '</td>' +
        '</tr>';

    $('#tabelKelas tbody').append(newRow);
}

// ==========================================
// SIMPAN EDITOR ACCESS KE DATABASE
// ==========================================
function saveEditorAccess(kelasId, mapelId) {
    $.ajax({
        url: config.urls.tambahEditorAccess,
        method: 'POST',
        data: {
            kelasId: kelasId,
            userId: config.userId,
            mapelId: mapelId,
            _token: config.csrfToken
        },
        success: function(response) {
            showSuccess(response.response || 'Data berhasil disimpan');
        },
        error: function(xhr, status, error) {
            console.error('Error saving editor access:', error);
            showAlert('Gagal menyimpan ke database: ' + error);
        }
    });
}

// ==========================================
// HANDLE DELETE ROW
// ==========================================
function handleDeleteRow(deleteButton) {
    let row = deleteButton.closest('tr');
    let rowIndexToDelete = row.index();
    
    if (confirm('Yakin ingin menghapus kelas dan mapel ini?')) {
        console.log('Deleting row index:', rowIndexToDelete);
        
        // Get data dari array
        let kelasId = rowData[rowIndexToDelete].kelas;
        let mapelId = rowData[rowIndexToDelete].mapel;
        
        // Delete dari database
        deleteEditorAccess(kelasId, mapelId, function() {
            // Hapus dari tabel dan array
            row.remove();
            rowData.splice(rowIndexToDelete, 1);
            rowIndex--;
            
            console.log('Row deleted successfully');
        });
    }
}

// ==========================================
// DELETE EDITOR ACCESS DARI DATABASE
// ==========================================
function deleteEditorAccess(kelasId, mapelId, callback) {
    $.ajax({
        url: config.urls.deleteEditorAccess,
        method: 'POST',
        data: {
            kelasId: kelasId,
            mapelId: mapelId,
            _token: config.csrfToken
        },
        success: function(response) {
            showSuccess(response.response || 'Data berhasil dihapus');
            if (callback) callback();
        },
        error: function(xhr, status, error) {
            console.error('Error deleting editor access:', error);
            showAlert('Gagal menghapus dari database: ' + error);
        }
    });
}

// ==========================================
// UTILITY FUNCTIONS
// ==========================================

// Reset form ke kondisi awal
function resetForm() {
    $('#kelas').val('kosong');
    resetMapelSelect();
    setTambahDisabled(true);
}

// Reset mapel select
function resetMapelSelect() {
    $('#mapel')
        .empty()
        .append('<option value="" selected>Pilih kelas terlebih dahulu</option>')
        .prop('disabled', true);
}

// Show/hide loading indicator
function showLoading(show) {
    $('#loading').toggle(show);
}

// Enable/disable mapel select
function setMapelDisabled(disabled) {
    $('#mapel').prop('disabled', disabled);
}

// Enable/disable tambah button
function setTambahDisabled(disabled) {
    $('#btnTambah').prop('disabled', disabled);
}

// Show alert message
function showAlert(message) {
    alert(message);
    // Bisa diganti dengan toast notification yang lebih bagus
}

// Show success message
function showSuccess(message) {
    console.log('Success:', message);
    // Bisa implementasi toast success di sini
    
    // Sementara pakai alert juga
    alert(message);
}

// ==========================================
// DEBUG FUNCTIONS (untuk development)
// ==========================================
function debugRowData() {
    console.log('Current rowData:', rowData);
    console.log('Current rowIndex:', rowIndex);
}

// Export functions untuk debugging (optional)
window.teacherSubjects = {
    debugRowData: debugRowData,
    resetForm: resetForm,
    rowData: rowData
};