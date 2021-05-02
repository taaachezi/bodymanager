-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2021 年 5 月 02 日 19:29
-- サーバのバージョン： 5.7.32
-- PHP のバージョン: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- データベース: `bodymanager`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL COMMENT '管理者ID',
  `name` varchar(10) NOT NULL COMMENT '管理者名',
  `email` varchar(32) NOT NULL COMMENT '管理者メールアドレス',
  `password` varchar(64) NOT NULL COMMENT '管理者パスワード'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `item_id`, `created_at`) VALUES
(21, 20, 26, '2021-04-19 10:36:32'),
(34, 1, 27, '2021-04-21 21:31:30'),
(41, 1, 29, '2021-04-22 21:32:13'),
(42, 1, 30, '2021-04-22 21:32:17'),
(43, 1, 35, '2021-04-28 20:52:26');

-- --------------------------------------------------------

--
-- テーブルの構造 `intakes`
--

CREATE TABLE `intakes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL COMMENT '数量',
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `intakes`
--

INSERT INTO `intakes` (`id`, `user_id`, `item_id`, `quantity`, `created_at`) VALUES
(43, 1, 29, 100, '2021-04-21'),
(44, 1, 28, 100, '2021-04-22'),
(45, 1, 30, 150, '2021-04-22'),
(47, 1, 28, 150, '2021-04-22'),
(48, 1, 29, 150, '2021-04-22'),
(51, 1, 29, 100, '2021-04-23'),
(52, 1, 30, 100, '2021-04-23'),
(72, 1, 30, 100, '2021-04-24'),
(73, 1, 30, 100, '2021-04-25'),
(74, 16, 32, 100, '2021-04-25'),
(75, 1, 30, 100, '2021-04-25'),
(76, 1, 30, 150, '2021-04-27'),
(77, 1, 30, 100, '2021-04-28');

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL COMMENT 'アイテムID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `name` varchar(20) NOT NULL COMMENT '食材名',
  `calorie` float NOT NULL COMMENT 'カロリー',
  `protein` float NOT NULL COMMENT 'たんぱく質',
  `fat` float NOT NULL COMMENT '脂質',
  `carbo` float NOT NULL COMMENT '炭水化物'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `items`
--

INSERT INTO `items` (`id`, `user_id`, `name`, `calorie`, `protein`, `fat`, `carbo`) VALUES
(26, 20, 'hoge', 357, 21, 21, 21),
(32, 16, 'hoge', 1331, 10, 139, 10),
(33, 1, 'サンプル', 428, 12, 32, 23),
(34, 1, '鶏胸肉', 172, 24, 4, 10),
(35, 1, '牛肉', 288, 21, 16, 15);

-- --------------------------------------------------------

--
-- テーブルの構造 `target_intakes`
--

CREATE TABLE `target_intakes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `calorie` float NOT NULL COMMENT '目標摂取カロリー',
  `protein` float NOT NULL COMMENT '目標摂取たんぱく質',
  `fat` float NOT NULL COMMENT '目標摂取脂質',
  `carbo` float NOT NULL COMMENT '目標摂取炭水化物'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `target_intakes`
--

INSERT INTO `target_intakes` (`id`, `user_id`, `calorie`, `protein`, `fat`, `carbo`) VALUES
(4, 1, 3243, 175, 63, 494),
(5, 20, 2173, 200, 20, 298.3),
(6, 16, 2077, 187.5, 18.8, 289.5);

-- --------------------------------------------------------

--
-- テーブルの構造 `total_intakes`
--

CREATE TABLE `total_intakes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `calorie` int(11) NOT NULL DEFAULT '0',
  `fat` int(11) NOT NULL,
  `protein` int(11) NOT NULL,
  `carbo` int(11) NOT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `total_intakes`
--

INSERT INTO `total_intakes` (`id`, `user_id`, `calorie`, `fat`, `protein`, `carbo`, `created_at`) VALUES
(36, 1, 935, 55, 55, 55, '2021-04-23'),
(49, 16, 1331, 139, 10, 10, '2021-04-23'),
(210, 16, 0, 0, 0, 0, '2021-04-24'),
(240, 1, 170, 10, 10, 10, '2021-04-24'),
(247, 16, 1331, 139, 10, 10, '2021-04-25'),
(255, 1, 340, 20, 20, 20, '2021-04-25'),
(258, 1, 0, 0, 0, 0, '2021-04-26'),
(274, 1, 255, 15, 15, 15, '2021-04-27'),
(295, 1, 0, 0, 0, 0, '2021-04-28');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'ユーザID',
  `name` varchar(10) NOT NULL COMMENT 'ユーザ名',
  `email` varchar(32) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(64) NOT NULL COMMENT 'パスワード',
  `height` float DEFAULT NULL COMMENT '身長',
  `weight` float DEFAULT NULL COMMENT '体重',
  `age` int(11) DEFAULT NULL COMMENT '年齢',
  `gender` int(11) DEFAULT '0' COMMENT '性別',
  `frequency` int(11) DEFAULT '1' COMMENT '運動頻度',
  `purpose` int(11) DEFAULT '0' COMMENT '目的',
  `role` int(11) NOT NULL DEFAULT '0' COMMENT '会員ステータス'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `height`, `weight`, `age`, `gender`, `frequency`, `purpose`, `role`) VALUES
(1, 'guest', 'guest@guest', '$2y$10$WMZyQFRkp65k0GvBBDN44uxlWIdIac50o4B0WmaE8DcTgfswBwojC', 175, 70, 26, 0, 0, 1, 0),
(12, 'wfef', 'wfe@wfe', '$2y$10$XhIIaLIdpjQtFasjCZU9B.vdoeY8B9YNRylw3CYuK.t2/7PJtl7Ja', NULL, NULL, NULL, 0, 1, 0, 0),
(16, 'hoge', 'hoge@hoge', '$2y$10$cDnswASHjShL5uLnuC1a/O5ggOVvwNWvStkOWOVLPVkeYuchVGe56', 175, 75, 23, 0, 1, 0, 0),
(18, 'fuge', 'fuge@fuge', '$2y$10$us1T7niy7Zk9RLdPBpWsCOvpAMKUJVgwVAMpmNLkWzkwF3sodmDE.', NULL, NULL, NULL, 0, 1, 0, 0),
(19, 'yuki', 'yuki@yuki', '$2y$10$ZNXXrzfiGUeZ5X1fbTiz9.OSsGP89VoOZZ.7UK6KtHYZMw7DMhch.', 173, 70, 26, 0, 1, 1, 0),
(20, 'fuga', 'fuga@fuga', '$2y$10$NP//fN/HfHT92n44.qSvTON18qpOgAydm6D8BylCFI0gFA9JdfEDy', 180, 80, 30, 0, 1, 0, 0),
(21, 'admin', 'admin@admin.com', '$2y$10$G/0V5eKyUnvCuuZo3M4bYeEg.Xh74AHXYJfm3WDWnNpcza9Z/M71.', NULL, NULL, NULL, 0, 1, 0, 2);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `intakes`
--
ALTER TABLE `intakes`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `target_intakes`
--
ALTER TABLE `target_intakes`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `total_intakes`
--
ALTER TABLE `total_intakes`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理者ID';

--
-- テーブルの AUTO_INCREMENT `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- テーブルの AUTO_INCREMENT `intakes`
--
ALTER TABLE `intakes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- テーブルの AUTO_INCREMENT `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'アイテムID', AUTO_INCREMENT=36;

--
-- テーブルの AUTO_INCREMENT `target_intakes`
--
ALTER TABLE `target_intakes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `total_intakes`
--
ALTER TABLE `total_intakes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ユーザID', AUTO_INCREMENT=22;
