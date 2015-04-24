<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This file is part of the PHP Methods Extension (http://rubengc.com/php-methods-extension)
 *
 * @author Ruben Garcia <contact@rubengc.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

if(!class_exists("FTP")) {
    class FTP {
        private $ftp;

        public function __construct($host, $username, $password, $port = 21, $timeout = 10)  {
            $this->ftp = ftp_connect($host, $port, $timeout);

            ftp_login($this->ftp, $username, $password);
        }

        public function __destruct() {
            ftp_close($this->ftp);
        }

        public function get($remoteFile, $localFile, $mode = FTP_BINARY) {
            if(!file_exists(dirname($localFile)))
                mkdir(dirname($localFile), 0777, true);

            if(file_exists($localFile))
                unlink($localFile);

            ftp_get($this->ftp, $localFile, $remoteFile, $mode);

            chmod($localFile, 0777);
        }

        public function getAll($remotePath, $localPath, $mode = FTP_BINARY) {
            $files = $this->ls($remotePath);

            foreach($files as $file) {
                $this->get($file, $localPath.$file, $mode);
            }
        }

        public function ls($path = "/") {
            return ftp_nlist($this->ftp, $path);
        }

        public function delete($file) {
            ftp_delete($this->ftp, $file);
        }

        public function deleteAll($path = "/") {
            $files = $this->ls($path);

            foreach($files as $file) {
                $this->delete($path.$file);
            }
        }

        public function remove($file) {
            ftp_delete($this->ftp, $file);
        }

        public function removeAll($path = "/") {
            $files = $this->ls($path);

            foreach($files as $file) {
                $this->remove($path.$file);
            }
        }

        public function passive($passive = true) {
            ftp_pasv($this->ftp, $passive);
        }

        public function close() {
            ftp_close($this->ftp);
        }
    }
}