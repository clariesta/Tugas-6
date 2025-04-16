<?php
$bandara_asal = [
    "Soekarno Hatta (CGK)" => 65000,
    "Husein Sastranegara (BDO)" => 50000,
    "Abdul Rachman Saleh (MLG)" => 40000,
    "Juanda (SUB)" => 30000
];

$bandara_tujuan = [
    "Ngurah Rai (DPS)" => 85000,
    "Hasanuddin (UPG)" => 70000,
    "Inanwatan (INX)" => 90000,
    "Sultan Iskandar Muda (BTJ)" => 60000
];

$hasil = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_maskapai = $_POST["nama_maskapai"];
    $asal = $_POST["asal"];
    $tujuan = $_POST["tujuan"];
    $harga_tiket = (int) $_POST["harga"];
    $tanggal = date("d F Y");
    $nomor = "FL" . rand(1000, 9999) . chr(rand(65, 90));
    
    // Extract airport codes
    preg_match('/\(([^)]+)\)/', $asal, $matches);
    $kode_asal = $matches[1] ?? '';
    preg_match('/\(([^)]+)\)/', $tujuan, $matches);
    $kode_tujuan = $matches[1] ?? '';

    // Hitung pajak
    $pajak1 = $bandara_asal[$asal]; 
    $pajak2 = $bandara_tujuan[$tujuan];
    $total_harga = $harga_tiket + $pajak1 + $pajak2;

    // TAMPILAN BOARDING PASS
    $hasil = "
    <div style='max-width:700px; margin:40px auto; font-family:\"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif;'>
        <div style='background: linear-gradient(to right, #fbc2eb, #a18cd1); color:white; padding:20px; border-radius:12px 12px 0 0; display:flex; justify-content:space-between; align-items:center;'>
            <div>
                <h1 style='margin:0; font-size:24px;'>Boarding Pass</h1>
                <p style='margin:5px 0 0; font-size:14px;'>$nama_maskapai • $nomor</p>
            </div>
            <div style='text-align:right;'>
                <p style='margin:0; font-size:14px;'>$tanggal</p>
                <p style='margin:5px 0 0; font-size:14px;'>Status: <span style='font-weight:bold;'>CONFIRMED</span></p>
            </div>
        </div>
        
        <div style='background:white; padding:25px; border-radius:0 0 12px 12px; box-shadow:0 5px 15px rgba(0,0,0,0.1);'>
            <div style='display:flex; justify-content:space-between; margin-bottom:30px;'>
                <div style='text-align:center;'>
                    <div style='font-size:28px; font-weight:bold;'>$kode_asal</div>
                    <div style='font-size:14px; color:#666;'>".explode(" (", $asal)[0]."</div>
                </div>
                
                <div style='text-align:center; align-self:center;'>
                    <div style='position:relative;'>
                        <div style='width:100px; height:1px; background:#ddd; position:absolute; top:50%; left:0;'></div>
                        <div style='width:12px; height:12px; border-radius:50%; background:#1a2980; display:inline-block; position:relative; z-index:1;'></div>
                        <div style='width:100px; height:1px; background:#ddd; position:absolute; top:50%; right:0;'></div>
                    </div>
                    <div style='font-size:12px; color:#888; margin-top:5px;'>Direct Flight</div>
                </div>
                
                <div style='text-align:center;'>
                    <div style='font-size:28px; font-weight:bold;'>$kode_tujuan</div>
                    <div style='font-size:14px; color:#666;'>".explode(" (", $tujuan)[0]."</div>
                </div>
            </div>
            
            <div style='display:flex; justify-content:space-between; margin-bottom:20px;'>
                <div>
                    <div style='font-size:12px; color:#888;'>Seat</div>
                    <div style='font-size:16px; font-weight:bold;'>".chr(rand(65, 70)).rand(1, 30)."</div>
                </div>
                <div>
                    <div style='font-size:12px; color:#888;'>Gate</div>
                    <div style='font-size:16px; font-weight:bold;'>".rand(1, 10)."</div>
                </div>
                <div>
                    <div style='font-size:12px; color:#888;'>Boarding</div>
                    <div style='font-size:16px; font-weight:bold;'>".date("H:i", strtotime("-1 hour"))."</div>
                </div>
            </div>
            
            <div style='background:#f9f9f9; padding:15px; border-radius:8px; margin-bottom:20px;'>
                <div style='display:flex; justify-content:space-between; margin-bottom:10px;'>
                    <span style='font-size:14px;'>Ticket Price:</span>
                    <span style='font-size:14px; font-weight:bold;'>Rp " . number_format($harga_tiket, 0, ',', '.') . "</span>
                </div>
                <div style='display:flex; justify-content:space-between; margin-bottom:10px;'>
                    <span style='font-size:14px;'>Departure Airport Tax:</span>
                    <span style='font-size:14px; font-weight:bold;'>Rp " . number_format($pajak1, 0, ',', '.') . "</span>
                </div>
                <div style='display:flex; justify-content:space-between; margin-bottom:10px;'>
                    <span style='font-size:14px;'>Arrival Airport Tax:</span>
                    <span style='font-size:14px; font-weight:bold;'>Rp " . number_format($pajak2, 0, ',', '.') . "</span>
                </div>
                <div style='display:flex; justify-content:space-between; border-top:1px dashed #ccc; padding-top:10px;'>
                    <span style='font-size:16px; font-weight:bold;'>Total:</span>
                    <span style='font-size:16px; font-weight:bold; color:#e74c3c;'>Rp " . number_format($total_harga, 0, ',', '.') . "</span>
                </div>
            </div>
        </div>
        
        <div style='text-align:center; margin-top:20px;'>
            <button style='padding:12px 25px; background:#9575cd; color:white; border:none; border-radius:25px; font-size:14px; cursor:pointer; margin-right:10px;'>
                <i class='fas fa-print'></i> Print Boarding Pass
            </button>
        </div>
    </div>";
}
?>

<!-- Formulir -->
<div style='max-width:700px; margin:40px auto; padding:0; background:white; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.1); overflow:hidden; font-family:"Segoe UI", Tahoma, Geneva, Verdana, sans-serif;'>
    <div style='background: linear-gradient(to right, #fbc2eb, #a18cd1); color:white; padding:20px;'>
        <h1 style='margin:0; text-align:center; font-size:28px;'>Flight Booking</h1>
    </div>
    
    <form method="POST" style='padding:30px;'>
        <div style='margin-bottom:25px;'>
            <label style='display:block; margin-bottom:8px; font-weight:bold; color:#555;'>Airline</label>
            <select name="nama_maskapai" required style='width:100%; padding:12px 15px; border:1px solid #ddd; border-radius:8px; font-size:16px; background-color:#f9f9f9;'>
                <option value="" disabled selected>Select Airline</option>
                <option>Garuda Indonesia</option>
                <option>Lion Air</option>
                <option>Citilink</option>
                <option>AirAsia</option>
            </select>
        </div>
        
        <div style='display:flex; gap:20px; margin-bottom:25px;'>
            <div style='flex:1;'>
                <label style='display:block; margin-bottom:8px; font-weight:bold; color:#555;'>Departure</label>
                <select name="asal" required style='width:100%; padding:12px 15px; border:1px solid #ddd; border-radius:8px; font-size:16px; background-color:#f9f9f9;'>
                    <option value="" disabled selected>From</option>
                    <?php foreach ($bandara_asal as $bandara => $pajak): ?>
                        <option value="<?= $bandara ?>"><?= $bandara ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div style='flex:1;'>
                <label style='display:block; margin-bottom:8px; font-weight:bold; color:#555;'>Arrival</label>
                <select name="tujuan" required style='width:100%; padding:12px 15px; border:1px solid #ddd; border-radius:8px; font-size:16px; background-color:#f9f9f9;'>
                    <option value="" disabled selected>To</option>
                    <?php foreach ($bandara_tujuan as $bandara => $pajak): ?>
                        <option value="<?= $bandara ?>"><?= $bandara ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div style='margin-bottom:30px;'>
            <label style='display:block; margin-bottom:8px; font-weight:bold; color:#555;'>Ticket Price (IDR)</label>
            <div style='position:relative;'>
                <span style='position:absolute; left:15px; top:50%; transform:translateY(-50%); font-weight:bold; color:#777;'>Rp</span>
                <input type="number" name="harga" required style='width:100%; padding:12px 15px 12px 40px; border:1px solid #ddd; border-radius:8px; font-size:16px; background-color:#f9f9f9;' placeholder='e.g. 1500000'>
            </div>
        </div>
        
        <button type="submit" style='width:100%; padding:15px; background: linear-gradient(to right, #fbc2eb, #a18cd1); color:white; border:none; border-radius:8px; font-size:18px; font-weight:bold; cursor:pointer; transition:all 0.3s;'>
            Book Flight
        </button>
    </form>
</div>

<?= $hasil ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">