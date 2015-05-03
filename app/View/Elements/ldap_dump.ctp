<?php
/**
 *  HE cPanel -- Hosting Engineers Control Panel
 *  Copyright (C) 2015  Dynamictivity LLC (http://www.hecpanel.com)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as
 *   published by the Free Software Foundation, either version 3 of the
 *   License, or (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>

<?php

if (!class_exists('ConnectionManager') || Configure::read('debug') < 2) {
    return false;
}
$noLogs = !isset($logs);
if ($noLogs):
    $sources = ConnectionManager::sourceList();

    $logs = array();
    foreach ($sources as $source):
        $db = ConnectionManager::getDataSource($source);
        if (!method_exists($db, 'getLog')):
            continue;
        endif;
        $logs[$source] = $db->getLog();
    endforeach;
endif;

if ($noLogs || isset($_forced_from_dbo_)):
    foreach ($logs as $source => $logInfo):
        $text = $logInfo['count'] > 1 ? 'queries' : 'query';
        printf(
            '<table class="cake-ldap-log" id="cakeSqlLog_%s" summary="Cake LDAP Log" cellspacing="0" border = "0">',
            preg_replace('/[^A-Za-z0-9_]/', '_', uniqid(time(), true))
        );
        printf('<caption>(%s) %s %s took %s ms</caption>', $source, $logInfo['count'], $text, $logInfo['time']);
    ?>
    <thead>
        <tr><th>Nr</th><th>Query</th><th>Error</th><th>Affected</th><th>Num. rows</th><th>Took (ms)</th></tr>
    </thead>
    <tbody>
        <?php
            foreach ($logInfo['log'] as $k => $i) :
                $i += array('error' => '');
                echo "<tr><td>" . ($k + 1) . "</td><td>" . h($i['query']) . "</td><td>{$i['error']}</td><td style = \"text-align: right\">{$i['affected']}</td><td style = \"text-align: right\">{$i['numRows']}</td><td style = \"text-align: right\">{$i['took']}</td></tr>\n";
            endforeach;
        ?>
    </tbody></table>
<?php
endforeach;
else:
    echo '<p>Encountered unexpected $logs cannot generate LDAP log</p>';
endif;