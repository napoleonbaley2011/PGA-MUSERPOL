<?php
$ldapconn = @ldap_connect("ldap://172.16.1.31:3890");
if ($ldapconn) {
    echo $ldapconn;
} else {
    echo "Error en la conexión LDAP";
}
