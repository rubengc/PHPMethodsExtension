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

if(!class_exists("SFTP")) {
    class SFTP {
        private $connection;
        private $sftp;

        public function __construct($host, $username, $password, $port = 22) {
            $this->connection = ssh2_connect($host, $port);

            ssh2_auth_password($this->connection, $username, $password);

            $this->sftp = ssh2_sftp($this->connection);
        }

        public function get($remoteFile, $localFile) {
            $stream = fopen("ssh2.sftp://".$this->sftp.(($remoteFile[0] != "/")?"/":"").$remoteFile, "r");

            $contents = "";
            while (!feof($stream)) {
                $contents .= fread($stream, 8192);
            }

            if(!file_exists(dirname($localFile)))
                mkdir(dirname($localFile), 0777, true);

            if(file_exists($localFile))
                unlink($localFile);

            $file = fopen($localFile, "w+");
            fclose($file);

            file_put_contents($localFile, $contents);

            fclose($stream);
        }

        public function getAll($remotePath, $localPath) {
            $files = $this->ls($remotePath);

            foreach($files as $file) {
                $this->get($remotePath.$file, $localPath.$file);
            }
        }

        function ls($remotePath = "/") {
            $array = array();
            $handle = opendir("ssh2.sftp://".$this->sftp.$remotePath);

            while (false !== ($file = readdir($handle))) {
                if (substr($file, 0, 1) != ".") {
                    if(is_dir($file)) {
                        //$array[$file] = $this->ls($remotePath."/".$file);
                    } else {
                        $array[] = $file;
                    }
                }
            }

            closedir($handle);

            return $array;
        }

        public function put($localFile, $remoteFile) {
            $stream = fopen("ssh2.sftp://".$this->sftp.(($remoteFile[0] != "/")?"/":"").$remoteFile, "w");

            $contents = file_get_contents($localFile);

            fwrite($stream, $contents);

            fclose($stream);
        }

        public function delete($remoteFile) {
            unlink("ssh2.sftp://".$this->sftp.(($remoteFile[0] != "/")?"/":"").$remoteFile);
        }

        public function deleteAll($remotePath = "/") {
            $files = $this->ls($remotePath);

            foreach($files as $file) {
                $this->delete($file);
            }
        }

        public function remove($remoteFile) {
            unlink("ssh2.sftp://".$this->sftp.(($remoteFile[0] != "/")?"/":"").$remoteFile);
        }

        public function removeAll($remotePath = "/") {
            $files = $this->ls($remotePath);

            foreach($files as $file) {
                $this->remove($file);
            }
        }
    }
}