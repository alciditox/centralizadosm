-- =============================================================
-- Índices para acelerar el módulo Consolidado De Pagos Procesados
-- Ejecutar este script en la base de datos MySQL/MariaDB
-- =============================================================

-- Índice compuesto para filtros principales (fecha + banco + status)
-- Cubre los filtros más comunes del formulario de búsqueda
ALTER TABLE `invoices`
ADD INDEX `idx_inv_fecha_banco_status` (`fecha_mes_cobro`, `banco`, `status`);

-- Índice para el LEFT JOIN: collections.invoice_id
-- Crítico para que el JOIN no haga full table scan
ALTER TABLE `collections`
ADD INDEX `idx_col_invoice_id` (`invoice_id`);

-- Índice individual para banco (útil cuando se filtra solo por banco)
ALTER TABLE `invoices`
ADD INDEX `idx_inv_banco` (`banco`);

-- Índice individual para status (útil cuando se filtra solo por status)
ALTER TABLE `invoices`
ADD INDEX `idx_inv_status` (`status`);

-- Nota: Si algún índice ya existe, MySQL dará un error "Duplicate key name"
-- En ese caso, simplemente ignorar ese ALTER TABLE.
