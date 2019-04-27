<?php include_once 'includes/header.php'; ?>

    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Tags Search</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php $url = !empty($_GET['q']) ? $_GET['q'] : null; ?>

            <br/>
            <form method="get" action="">
                <div class="form-group">
                    <div class="input-group">
                        <input type="search" name="q" class="form-control" value="<?php echo $url; ?>" placeholder="Enter Web Address (URL) to fetch..."/>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-dark" title="Search">&nbsp;&rightarrow;</button>
                        </div>
                    </div>
                </div>
            </form>
            <hr/>
        </div>

        <?php if (!empty($url)): ?>
            <?php
            #$context = stream_context_create(['http' => ['method' => 'GET', 'max_redirects' => '0', 'ignore_errors' => '1']]);
            #$file_contents = @file_get_contents($url);
            $file_contents = fileGetContentsByCurl($url);
            $file_contents_f = htmlentities($file_contents);

            # get the pre-selected tag name
            $tag_name_pre = !empty($_GET['tag']) ? $_GET['tag'] : null;
            if (!is_null($tag_name_pre)) {
                $search = ['&lt;' . $tag_name_pre, '&lt;/' . $tag_name_pre . '&gt;'];
                $replace = ['<span class="bg-warning">&lt;' . $tag_name_pre . '</span>', '<span class="bg-warning">&lt;/' . $tag_name_pre . '&gt;</span>'];
                $file_contents_f = str_replace($search, $replace, $file_contents_f);
            }

            $dm = new DOMDocument();
            @$dm->loadHTML($file_contents);

            $html_tags = getHtmlTagsWithCount($dm);
            ksort($html_tags, SORT_STRING);
            ?>
            <div class="col-md-12">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pill-vs-tab" data-toggle="pill" href="#view-source" aria-controls="pill-vs" role="tab">View Source</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pill-ds-tab" data-toggle="pill" href="#document-summary" aria-controls="pill-ds" role="tab">Document Summary</a>
                    </li>
                </ul>
                <div class="tab-content mb-4" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="view-source" role="tabpanel" aria-labelledby="pill-vs-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pre-scrollable bg-white">
                                            <pre><code><?= $file_contents_f; ?></code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="document-summary" role="tabpanel" aria-labelledby="pill-ds-tab">
                        <div class="table-responsive">
                            <table class="table text-left m-0 bg-white">
                                <thead class="font-weight-bold">
                                <tr class="bg-dark text-white">
                                    <th>Tags/Count</th>
                                    <th>Document Structure &mdash; Mini</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr valign="top">
                                    <td width="40%" class="p-0">
                                        <ul class="list-group">
                                            <?php foreach ($html_tags as $tag_name => $tag_count) { ?>
                                                <li class="list-group-item list-group-item-action<?= ($tag_name_pre == $tag_name ? ' active' : ''); ?>">
                                                    <a href="?q=<?= $url; ?>&tag=<?= $tag_name; ?>" class="text-dark justify-content-between align-items-center d-flex">
                                                        &lt;<?= $tag_name; ?>&gt;
                                                        <span class="badge badge-secondary badge-pill"><?= $tag_count; ?></span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                    <td><?php displayNodes($dm); ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php include_once 'includes/footer.php'; ?>