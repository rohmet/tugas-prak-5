<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Makanan Khas Sulawesi Selatan</title>
    <link rel="stylesheet" href="assets/style.css" />
  </head>

  <body>
    <header>
        <div class="header-left">Makanan Khas</div>
        <div class="header-right">
            Hi, <?php echo $_SESSION['username']; ?> 
            <a href="logout.php" class="btn-logout">Keluar</a>
        </div>
    </header>


    <div class="containerr">
      <!-- Sidebar -->
      <aside class="sidebar">
        <nav>
          <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="tabel-makanan.html">Makanan Khas</a></li>
            <li><a href="obyek-wisata.html">Objek Wisata</a></li>
            <li><a href="index.php">Keluar</a></li>
          </ul>
        </nav>
      </aside>
      <!-- Konten Utama -->
      <section class="content">
        <h1>Daftar Makanan Khas Sulawesi Selatan</h1>
        <!-- Formulir Tambah Makanan -->
        <form id="food-form">
          <h2>Tambah Makanan Khas</h2>
          <label for="food-name">Nama Makanan:</label>
          <input
            type="text"
            id="food-name"
            name="food-name"
            placeholder="Masukkan nama makanan..."
          />

          <label for="food-desc">Deskripsi Makanan:</label>
          <input
            type="text"
            id="food-desc"
            name="food-desc"
            placeholder="Masukkan deskripsi makanan..."
          />
          <label for="food-image">Gambar Makanan:</label>
          <input type="file" id="food-image" name="food-image" />

          <div class="add-button">
            <button type="submit" id="submit-btn">Tambah</button>
          </div>
        </form>

        <!-- Tabel Informasi Makanan -->
        <table id="food-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Makanan</th>
              <th>Gambar</th>
              <th>Deskripsi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Coto Makassar</td>
              <td>
                <img
                  src="assets/coto-makassar.jpg"
                  alt="Coto Makassar"
                  width="100"
                />
              </td>
              <td>
                Hidangan sup tradisional khas Makassar, terbuat dari daging sapi
                dan rempah khas.
              </td>
              <td>
                <button class="edit-btn" onclick="editRow(this)">Edit</button>
                <button class="delete-btn" onclick="deleteRow(this)">
                  Hapus
                </button>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Pallubasa</td>
              <td>
                <img src="assets/pallubasa.jpg" alt="Pallubasa" width="100" />
              </td>
              <td>
                Makanan khas Makassar, mirip dengan Coto Makassar namun dengan
                tambahan kelapa parut.
              </td>
              <td>
                <button class="edit-btn" onclick="editRow(this)">Edit</button>
                <button class="delete-btn" onclick="deleteRow(this)">
                  Hapus
                </button>
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>Pisang Ijo</td>
              <td>
                <img src="assets/pisang-ijo.jpg" alt="Pisang Ijo" width="100" />
              </td>
              <td>
                Hidangan penutup berbahan dasar pisang yang dibalut dengan
                adonan tepung berwarna hijau.
              </td>
              <td>
                <button class="edit-btn" onclick="editRow(this)">Edit</button>
                <button class="delete-btn" onclick="deleteRow(this)">
                  Hapus
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </section>
    </div>

    <script>
      let editingRow = null;

      // Mengakses elemen
      const foodForm = document.getElementById("food-form");
      const foodTable = document
        .getElementById("food-table")
        .getElementsByTagName("tbody")[0];
      const submitBtn = document.getElementById("submit-btn");

      foodForm.addEventListener("submit", function (e) {
        e.preventDefault();

        // Mengambil nilai input
        const foodName = document.getElementById("food-name").value.trim();
        const foodDesc = document.getElementById("food-desc").value.trim();
        const foodImage = document.getElementById("food-image").files[0];

        // divalidasi kih klo nd ada gambarnya kak
        if (!foodName || !foodDesc || (!editingRow && !foodImage)) {
          alert("Nama, Deskripsi, dan Gambar harus diisi");
          return;
        }

        if (editingRow) {
          editingRow.cells[1].textContent = foodName;
          editingRow.cells[3].textContent = foodDesc;

          // klo ada gambar baru diubah, diperbarui
          if (foodImage) {
            const reader = new FileReader();
            reader.onload = function (e) {
              editingRow.cells[2].innerHTML = `<img src="${e.target.result}" alt="${foodName}" width="100">`;
            };
            reader.readAsDataURL(foodImage);
          }

          // direset form nya
          foodForm.reset();
          submitBtn.textContent = "Tambah";
          editingRow = null;
          return;
        }

        const newRow = foodTable.insertRow();
        const cellNo = newRow.insertCell(0);
        const cellName = newRow.insertCell(1);
        const cellImage = newRow.insertCell(2);
        const cellDesc = newRow.insertCell(3);
        const cellAction = newRow.insertCell(4);

        // set isi cell
        cellNo.textContent = foodTable.rows.length;
        cellName.textContent = foodName;

        // Baca gambar yang diunggah
        const reader = new FileReader();
        reader.onload = function (e) {
          cellImage.innerHTML = `<img src="${e.target.result}" alt="${foodName}" width="100">`;
        };
        reader.readAsDataURL(foodImage);

        cellDesc.textContent = foodDesc;
        cellAction.innerHTML = `
      <button class="edit-btn" onclick="editRow(this)">Edit</button>
      <button class="delete-btn" onclick="deleteRow(this)">Hapus</button>
    `;

        // Kosongkan input form
        foodForm.reset();
      });

      function deleteRow(button) {
        const konfirmasi = confirm(
          "Apakah Anda yakin ingin menghapus data ini?"
        );
        if (!konfirmasi) return;

        const row = button.parentElement.parentElement;
        row.parentElement.removeChild(row);

        //di update kih nomor baris nya
        const rows = foodTable.rows;
        for (let i = 0; i < rows.length; i++) {
          rows[i].cells[0].textContent = i + 1;
        }
      }

      // buat edit kak
      function editRow(button) {
        editingRow = button.parentElement.parentElement;

        const foodName = editingRow.cells[1].textContent;
        const foodDesc = editingRow.cells[3].textContent;

        const imgTag = editingRow.cells[2].querySelector("img");
        const foodImageSrc = imgTag ? imgTag.src : "";

        document.getElementById("food-name").value = foodName;
        document.getElementById("food-desc").value = foodDesc;

        alert(
          "Silakan ubah data yang diinginkan. Gambar tetap sama jika tidak diunggah ulang."
        );

        submitBtn.textContent = "Simpan";
      }
    </script>
  </body>
</html>
