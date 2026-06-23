import time
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.keys import Keys
from base_test import BaseTest
from config import BASE_URL, ADMIN_EMAIL, ADMIN_PASSWORD

class TestSiswaCRUD(BaseTest):
    nis_target = "002"
    nama_target = "Andi"
    nama_update = "Andi Update"

    def setUp(self):
        super().setUp()
        self.login(ADMIN_EMAIL, ADMIN_PASSWORD)
        self.id_kelas = 1

    def test_01_store_P1_sukses(self):
        """Path 1: Validasi berhasil, data tersimpan"""
        self.driver.get(f"{BASE_URL}/kelas/{self.id_kelas}/siswa/create")
        time.sleep(1)
        
        input_nis = self.wait.until(EC.presence_of_element_located((By.ID, "nis")))
        input_nama = self.wait.until(EC.presence_of_element_located((By.ID, "nama")))
        
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", input_nis)
        
        self.driver.execute_script(f"arguments[0].value = '{self.nis_target}';", input_nis)
        self.driver.execute_script(f"arguments[0].value = '{self.nama_target}';", input_nama)
        time.sleep(1)
        
        btn_submit = self.driver.find_element(By.XPATH, "//button[contains(., 'Simpan Data')]")
        self.driver.execute_script("arguments[0].click();", btn_submit)
        
        self.wait.until(EC.presence_of_element_located((By.CLASS_NAME, "bg-green-50")))
        self.assertIn(self.nama_target, self.driver.page_source)

    def test_02_store_P2_gagal_validasi(self):
        """Path 2: Validasi gagal (NIS duplikat)"""
        self.driver.get(f"{BASE_URL}/kelas/{self.id_kelas}/siswa/create")
        time.sleep(1)
        
        input_nis = self.wait.until(EC.presence_of_element_located((By.ID, "nis")))
        input_nama = self.wait.until(EC.presence_of_element_located((By.ID, "nama")))
        
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", input_nis)
        
        self.driver.execute_script(f"arguments[0].value = '{self.nis_target}';", input_nis)
        self.driver.execute_script(f"arguments[0].value = '{self.nama_target} Kloning';", input_nama)
        time.sleep(1)
        
        btn_submit = self.driver.find_element(By.XPATH, "//button[contains(., 'Simpan Data')]")
        self.driver.execute_script("arguments[0].click();", btn_submit)
        time.sleep(1)
        
        self.assertIn('/siswa/create', self.driver.current_url)
        self.assertIn('sudah ada', self.driver.page_source)

    def test_03_edit_P1_sukses(self):
        """Path 1: Data siswa ditemukan (menampilkan form edit)"""
        self.driver.get(f"{BASE_URL}/kelas/{self.id_kelas}")
        time.sleep(2)

        row_xpath = f"//tr[td[contains(., '{self.nis_target}')]]"
        self.wait.until(EC.presence_of_element_located((By.XPATH, row_xpath)))

        xpath_target = f"{row_xpath}//a[@title='Edit']"
        btn_edit = self.wait.until(EC.element_to_be_clickable((By.XPATH, xpath_target)))

        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", btn_edit)
        time.sleep(0.5)

        self.driver.execute_script("arguments[0].click();", btn_edit)

        self.wait.until(EC.url_contains("/edit"))
        self.assertIn(self.nama_target, self.driver.page_source)
        
    def test_04_edit_P2_not_found(self):
        """Path 2: Data siswa tidak ditemukan (ID dimanipulasi)"""
        self.driver.get(f"{BASE_URL}/kelas/{self.id_kelas}/siswa/9999/edit")
        time.sleep(1)
        
        is_edit_page = "/edit" in self.driver.current_url
        if is_edit_page:
            fields = self.driver.find_elements(By.ID, "nama")
            self.assertEqual(len(fields), 0, "Tidak seharusnya menampilkan form edit")

    def test_05_update_P1_gagal_validasi(self):
        """Path 1: Validasi update gagal (Nama dikosongkan)"""
        self.driver.get(f"{BASE_URL}/kelas/{self.id_kelas}")
        time.sleep(1)
        
        xpath_target = f"//tr[td[contains(., '{self.nis_target}')]]//a[@title='Edit']"
        btn_edit = self.wait.until(EC.presence_of_element_located((By.XPATH, xpath_target)))
        self.driver.execute_script("arguments[0].click();", btn_edit)
        self.wait.until(EC.url_contains("/edit"))
        time.sleep(1)
        
        field_nama = self.wait.until(EC.presence_of_element_located((By.ID, "nama")))
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", field_nama)
        
        self.driver.execute_script("arguments[0].value = '';", field_nama)
        time.sleep(1)
        
        btn_submit = self.driver.find_element(By.XPATH, "//button[contains(., 'Simpan Perubahan')]")
        self.driver.execute_script("arguments[0].click();", btn_submit)
        time.sleep(1)
        
        self.assertIn('/edit', self.driver.current_url)

    def test_06_update_P2_not_found(self):
        """Path 2: Validasi berhasil, tetapi data tidak ditemukan di database (ID dimanipulasi)"""
        self.driver.get(f"{BASE_URL}/kelas/{self.id_kelas}")
        time.sleep(1)
        
        xpath_target = f"//tr[td[contains(., '{self.nis_target}')]]//a[@title='Edit']"
        btn_edit = self.wait.until(EC.presence_of_element_located((By.XPATH, xpath_target)))
        self.driver.execute_script("arguments[0].click();", btn_edit)
        self.wait.until(EC.url_contains("/edit"))
        time.sleep(1)
        
        field_nama = self.wait.until(EC.presence_of_element_located((By.ID, "nama")))
        form_element = field_nama.find_element(By.XPATH, "./ancestor::form")
        self.driver.execute_script("arguments[0].action = '/kelas/1/siswa/9999';", form_element)
        
        btn_submit = self.driver.find_element(By.XPATH, "//button[contains(., 'Simpan Perubahan')]")
        self.driver.execute_script("arguments[0].click();", btn_submit)
        time.sleep(1)
        
        self.driver.get(f"{BASE_URL}/kelas/{self.id_kelas}")
        time.sleep(1)
        self.assertIn(self.nis_target, self.driver.page_source)
        self.assertIn(self.nama_target, self.driver.page_source)
        self.assertNotIn(self.nama_update, self.driver.page_source)
        
    def test_07_update_P3_sukses(self):
        """Path 3: Validasi berhasil dan data diupdate"""
        self.driver.get(f"{BASE_URL}/kelas/{self.id_kelas}")
        time.sleep(1)
        
        xpath_target = f"//tr[td[contains(., '{self.nis_target}')]]//a[@title='Edit']"
        btn_edit = self.wait.until(EC.presence_of_element_located((By.XPATH, xpath_target)))
        self.driver.execute_script("arguments[0].click();", btn_edit)
        self.wait.until(EC.url_contains("/edit"))
        time.sleep(1)
        
        field_nama = self.wait.until(EC.presence_of_element_located((By.ID, "nama")))
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", field_nama)
        
        self.driver.execute_script(f"arguments[0].value = '{self.nama_update}';", field_nama)
        time.sleep(1)
        
        btn_submit = self.driver.find_element(By.XPATH, "//button[contains(., 'Simpan Perubahan')]")
        self.driver.execute_script("arguments[0].click();", btn_submit)
        
        self.wait.until(EC.presence_of_element_located((By.CLASS_NAME, "bg-green-50")))
        self.assertIn(self.nama_update, self.driver.page_source)

    def test_08_destroy_P2_not_found(self):
        """Path 2: Data siswa yang akan dihapus tidak ditemukan (ID dimanipulasi)"""
        self.driver.get(f"{BASE_URL}/kelas/{self.id_kelas}")
        time.sleep(1)
        
        xpath_target = f"//tr[td[contains(., '{self.nis_target}')]]//button[@title='Hapus']"
        btn_hapus = self.wait.until(EC.element_to_be_clickable((By.XPATH, xpath_target)))
        
        form_element = btn_hapus.find_element(By.XPATH, "./ancestor::form")
        self.driver.execute_script("arguments[0].action = '/kelas/1/siswa/9999';", form_element)
        
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", btn_hapus)
        time.sleep(1)
        
        btn_hapus.click()
        
        self.wait.until(EC.alert_is_present())
        alert = self.driver.switch_to.alert
        alert.accept()
        time.sleep(1)
        
        page_source = self.driver.page_source
        self.assertTrue('404' in page_source or 'Not Found' in page_source)
        
    def test_09_destroy_P1_sukses(self):
        """Path 1: Hapus data yang valid (berdasarkan NIS target)"""
        self.driver.get(f"{BASE_URL}/kelas/{self.id_kelas}")
        time.sleep(2)

        self.assertIn(self.nis_target, self.driver.page_source, "Data dengan NIS target tidak ditemukan!")

        xpath_target = f"//tr[td[contains(., '{self.nis_target}')]]//button[@title='Hapus']"
        btn_hapus = self.wait.until(EC.element_to_be_clickable((By.XPATH, xpath_target)))

        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", btn_hapus)
        time.sleep(1)

        self.driver.execute_script("arguments[0].click();", btn_hapus)
        time.sleep(1)

        try:
            alert = self.wait.until(EC.alert_is_present())
            alert.accept()
        except TimeoutException:
            # Fallback: submit form secara langsung
            form = btn_hapus.find_element(By.XPATH, "./ancestor::form")
            self.driver.execute_script("arguments[0].submit();", form)
            time.sleep(1)
            alert = self.wait.until(EC.alert_is_present())
            alert.accept()

        self.wait.until(EC.presence_of_element_located((By.CLASS_NAME, "bg-green-50")))
        
        self.assertNotIn(self.nama_update, self.driver.page_source)
        self.assertNotIn(self.nis_target, self.driver.page_source)