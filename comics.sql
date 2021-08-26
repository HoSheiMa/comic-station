-- Database: `comics`
-- --------------------------------------------------------
-- Table structure for table `emails`

CREATE TABLE `emails` (
  `email` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

